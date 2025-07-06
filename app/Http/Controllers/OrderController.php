<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Eduwisata;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemesan'      => 'required|string|max:100',
            'telepon'           => 'required|string|max:20',
            'alamat'            => 'nullable|string|max:255',
            'jumlah'            => 'nullable|numeric|min:0.01',
            'jumlah_orang'      => 'nullable|integer|min:1',
            'tanggal_kunjungan' => 'nullable|date',
            'produk_id'         => 'nullable|exists:products,id',
            'eduwisata_id'      => 'nullable|exists:eduwisatas,id',
            'keterangan'        => 'nullable|string|max:255'
        ]);

        // Hitung total_harga dan ambil data produk/eduwisata dalam satu query
        $produk = null;
        $eduwisata = null;
        $namaItem = 'Produk';

        if (!empty($data['eduwisata_id'])) {
            $eduwisata = Eduwisata::find($data['eduwisata_id']);
            $namaItem = $eduwisata->name ?? 'Eduwisata';
            $jumlah = $data['jumlah_orang'] ?? 0;
            $tanggal = $data['tanggal_kunjungan'] ?? null;
            
            // Validasi minimal 5 orang per grup
            if ($jumlah < 5) {
                return back()->withErrors([
                    'jumlah_orang' => 'Minimal 5 orang per grup untuk pemesanan eduwisata.'
                ])->withInput();
            }
            
            // Validasi kapasitas harian (maksimal 15 orang per hari)
            if ($tanggal) {
                $totalBookedToday = Order::where('eduwisata_id', $data['eduwisata_id'])
                    ->where('tanggal_kunjungan', $tanggal)
                    ->sum('jumlah_orang');
                
                $availableSlots = 15 - $totalBookedToday;
                
                if ($jumlah > $availableSlots) {
                    return back()->withErrors([
                        'jumlah_orang' => "Maaf, untuk tanggal $tanggal hanya tersisa $availableSlots slot. Maksimal 15 orang per hari."
                    ])->withInput();
                }
            }
            
            $harga = 14000;
            if ($jumlah >= 20) {
                $harga = 10000;
            } elseif ($jumlah >= 10) {
                $harga = 12000;
            }
            $data['total_harga'] = $harga * $jumlah;

        } elseif (!empty($data['produk_id'])) {
            $produk = Product::find($data['produk_id']);
            $namaItem = $produk->name ?? 'Produk';
            $jumlah = $data['jumlah'] ?? 1;
            
            // Check if quantity is valid based on min_increment
            if ($produk && $produk->min_increment > 0) {
                $remainder = fmod($jumlah, $produk->min_increment);
                if (abs($remainder) > 0.00001) {
                    return back()->with('error', "Jumlah harus kelipatan {$produk->min_increment} {$produk->unit}.");
                }
            }
            
            // Calculate total price with bundle logic
            if ($produk && $produk->hasBundle()) {
                $breakdown = $produk->getBundleBreakdown($jumlah);
                $data['total_harga'] = $breakdown['total'];
                
                // Add bundle info to message
                if ($breakdown['bundles'] > 0) {
                    $bundleInfo = "Bundle: {$breakdown['bundles']}x{$produk->bundle_quantity}";
                    if ($breakdown['remaining'] > 0) {
                        $bundleInfo .= " + {$breakdown['remaining']} satuan";
                    }
                    $data['keterangan'] = ($data['keterangan'] ?? '') . " ($bundleInfo)";
                }
                
                // Add bundle breakdown for WhatsApp message
                $data['bundle_breakdown'] = $breakdown;
                $data['bundle_quantity'] = $produk->bundle_quantity;
            } else {
                $data['total_harga'] = $produk ? ($produk->price * $jumlah) : 0;
            }
        }

        $order = Order::create($data);

        // Simpan session untuk tracking riwayat user
        session()->put('telepon', $data['telepon']);

        // --- Kirim notifikasi via Fonnte ---
        $fonnteService = new FonnteService();
        
        // Prepare order data for notification
        $orderData = [
            'nama_pemesan' => $data['nama_pemesan'],
            'telepon' => $data['telepon'],
            'alamat' => $data['alamat'] ?? '-',
            'jumlah_orang' => $data['jumlah_orang'] ?? null,
            'jumlah' => $data['jumlah'] ?? null,
            'tanggal_kunjungan' => $data['tanggal_kunjungan'] ?? '-',
            'total_harga' => $data['total_harga'],
            'nama_item' => $namaItem,
            'keterangan' => $data['keterangan'] ?? '',
            'unit' => $produk ? $produk->unit : 'orang'
        ];

        // Send notification to admin
        $fonnteService->sendOrderNotification($orderData);
        
        // Send confirmation to customer
        $fonnteService->sendOrderConfirmation($orderData);

        // ✅ Redirect ke halaman sukses
        return redirect()->route('order.success')->with('success', 'Pesanan berhasil dikirim! Admin akan segera menghubungi Anda.');
    }

    // New method for checkout from cart
    public function checkoutFromCart(Request $request)
    {
        $request->validate([
            'nama_pemesan'      => 'required|string|max:100',
            'telepon'           => 'required|string|max:20',
            'alamat'            => 'required|string|max:255',
            'keterangan'        => 'nullable|string|max:255'
        ]);

        $sessionId = session()->getId();
        $cartItems = CartItem::with('product')
            ->where('session_id', $sessionId)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang belanja kosong!');
        }

        // Calculate total with bundle logic
        $totalHarga = 0;
        $bundleInfo = [];
        $allBundleBreakdowns = [];
        
        foreach ($cartItems as $item) {
            $product = $item->product;
            $quantity = $item->quantity;
            
            $breakdown = $product->getBundleBreakdown($quantity);
            $totalHarga += $breakdown['total'];
            
            // Store bundle info for WhatsApp message
            if ($breakdown['bundles'] > 0) {
                $bundleText = "Bundle: {$breakdown['bundles']}x{$product->bundle_quantity}";
                if ($breakdown['remaining'] > 0) {
                    $bundleText .= " + {$breakdown['remaining']} satuan";
                }
                $bundleText .= " {$product->unit}";
                $bundleInfo[] = $bundleText;
                
                // Store detailed breakdown for WhatsApp
                $allBundleBreakdowns[] = [
                    'product_name' => $product->name,
                    'breakdown' => $breakdown,
                    'bundle_quantity' => $product->bundle_quantity,
                    'unit' => $product->unit
                ];
            }
        }

        // Create order
        $order = Order::create([
            'nama_pemesan' => $request->nama_pemesan,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
            'keterangan' => $request->keterangan
        ]);

        // Create order items with bundle calculation
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $quantity = $cartItem->quantity;
            
            $breakdown = $product->getBundleBreakdown($quantity);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $quantity,
                'price_per_unit' => $product->price, // Store regular price for reference
                'subtotal' => $breakdown['total']
            ]);
        }

        // Clear cart
        CartItem::where('session_id', $sessionId)->delete();

        // Save session for tracking
        session()->put('telepon', $request->telepon);

        // Prepare data for WhatsApp notification
        $orderData = [
            'nama_pemesan' => $request->nama_pemesan,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'total_harga' => $totalHarga,
            'nama_item' => 'Beberapa Produk',
            'keterangan' => $request->keterangan ?? '',
            'jenis' => 'produk',
            'all_bundle_breakdowns' => $allBundleBreakdowns
        ];

        // Send WhatsApp notification
        $fonnteService = new \App\Services\FonnteService();
        $fonnteService->sendOrderNotification($orderData);
        $fonnteService->sendOrderConfirmation($orderData);

        // Generate WhatsApp message for multiple products
        $nama = $request->nama_pemesan;
        $telepon = $request->telepon;
        $alamat = $request->alamat;
        $keterangan = $request->keterangan ?? '-';

        $waText = "Halo Admin, saya ingin memesan *Beberapa Produk*:\n" .
                "- Nama: $nama\n" .
                "- No HP: $telepon\n" .
                "- Alamat: $alamat\n" .
                "- Keterangan: $keterangan\n\n";

        $waText .= "*Detail Produk:*\n";
        foreach ($cartItems as $item) {
            $product = $item->product;
            $quantity = $item->quantity;
            $unit = $product->unit;
            
            if ($product->hasBundle()) {
                $bundleQuantity = $product->bundle_quantity;
                $bundlePrice = $product->bundle_price;
                $regularPrice = $product->price;
                
                // Calculate bundle info
                $completeBundles = intval($quantity / $bundleQuantity);
                $remainingItems = $quantity % $bundleQuantity;
                
                $waText .= "• {$product->name}: {$quantity} {$unit}\n";
                
                if ($completeBundles > 0) {
                    $waText .= "  - Bundle: {$completeBundles}x{$bundleQuantity} = Rp " . 
                              number_format($completeBundles * $bundlePrice, 0, ',', '.') . "\n";
                }
                
                if ($remainingItems > 0) {
                    $waText .= "  - Regular: {$remainingItems}x = Rp " . 
                              number_format($remainingItems * $regularPrice, 0, ',', '.') . "\n";
                }
                
                // Calculate total for this item
                $bundleTotal = $completeBundles * $bundlePrice;
                $regularTotal = $remainingItems * $regularPrice;
                $itemTotal = $bundleTotal + $regularTotal;
                
                $waText .= "  Total: Rp " . number_format($itemTotal, 0, ',', '.') . "\n";
            } else {
                $waText .= "• {$product->name}: {$quantity} {$unit} x Rp " . 
                          number_format($product->price, 0, ',', '.') . 
                          " = Rp " . number_format($quantity * $product->price, 0, ',', '.') . "\n";
            }
        }

        $waText .= "\n*Total: Rp " . number_format($totalHarga, 0, ',', '.') . "*";

        $waNumber = '6282379044166';
        $waUrl = "https://wa.me/$waNumber?text=" . urlencode($waText);

        return redirect()->away($waUrl);
    }

    public function index(Request $request)
    {
        $query = Order::with(['produk', 'eduwisata', 'orderItems.product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('jenis')) {
            if ($request->jenis == 'produk') {
                $query->where(function ($q) {
                    $q->whereNotNull('produk_id')
                      ->orWhereHas('orderItems');
                });
            } elseif ($request->jenis == 'eduwisata') {
                $query->whereNotNull('eduwisata_id');
            }
        }

        $orders = $query->latest()->paginate(10);
        return view('dashboard.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:menunggu,disetujui,ditolak,selesai']);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }

   public function exportManual()
    {
        $orders = Order::with(['produk', 'eduwisata', 'orderItems.product'])->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Pemesanan');

        // Header kolom
        $headers = [
            'Nama Pemesan', 'Telepon', 'Alamat', 'Jumlah (Orang/Kg)',
            'Produk/Wisata', 'Total Harga', 'Status',
            'Tanggal Order', 'Tanggal Kunjungan', 'Catatan'
        ];
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        // Isi data baris
        $row = 2;
        foreach ($orders as $order) {
            if ($order->orderItems->isNotEmpty()) {
                // Multiple products order
                foreach ($order->orderItems as $item) {
                    $unit = $item->product->unit;
                    $sheet->setCellValue('A' . $row, $order->nama_pemesan);
                    $sheet->setCellValue('B' . $row, $order->telepon);
                    $sheet->setCellValue('C' . $row, $order->alamat ?? '-');
                    $sheet->setCellValue('D' . $row, $item->quantity . ' ' . $unit);
                    $sheet->setCellValue('E' . $row, $item->product->name);
                    $sheet->setCellValue('F' . $row, $item->subtotal);
                    $sheet->setCellValue('G' . $row, ucfirst($order->status));
                    $sheet->setCellValue('H' . $row, $order->created_at->format('Y-m-d'));
                    $sheet->setCellValue('I' . $row, $order->tanggal_kunjungan ?? '-');
                    $sheet->setCellValue('J' . $row, $order->keterangan ?? '-');
                    $row++;
                }
            } else {
                // Single product/eduwisata order
                $jenis = $order->produk->name ?? ($order->eduwisata->name ?? '-');
                $unit = $order->produk ? $order->produk->unit : 'org';
                $jumlah = $order->produk_id
                    ? (($order->jumlah ?? 0) . ' ' . $unit)
                    : (($order->jumlah_orang ?? 0) . ' ' . $unit);

                $sheet->setCellValue('A' . $row, $order->nama_pemesan);
                $sheet->setCellValue('B' . $row, $order->telepon);
                $sheet->setCellValue('C' . $row, $order->alamat ?? '-');
                $sheet->setCellValue('D' . $row, $jumlah);
                $sheet->setCellValue('E' . $row, $jenis);
                $sheet->setCellValue('F' . $row, $order->total_harga);
                $sheet->setCellValue('G' . $row, ucfirst($order->status));
                $sheet->setCellValue('H' . $row, $order->created_at->format('Y-m-d'));
                $sheet->setCellValue('I' . $row, $order->tanggal_kunjungan ?? '-');
                $sheet->setCellValue('J' . $row, $order->keterangan ?? '-');
                $row++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_pesanan_' . date('Ymd_His') . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), 'xlsx');
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }

    public function riwayatProduk($telepon)
    {
        $orders = Order::with(['orderItems.product', 'produk'])
            ->where('telepon', $telepon)
            ->where(function ($query) {
                $query->whereHas('orderItems')
                      ->orWhereNotNull('produk_id');
            })
            ->latest()
            ->get();

        return view('Frontend.orders.riwayat_produk', compact('orders'));
    }

    public function riwayatEduwisata($telepon)
    {
        $orders = Order::with(['eduwisata' => function($query) {
                $query->select('id', 'name', 'harga');
            }])
            ->where('telepon', $telepon)
            ->whereNotNull('eduwisata_id')
            ->latest()
            ->get();
        return view('Frontend.orders.riwayat_eduwisata', compact('orders'));
    }

    public function orderNowForm($productId, Request $request)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $jumlah = $request->query('jumlah', $product->min_increment);
        return view('Frontend.product.order_now', compact('product', 'jumlah'));
    }
}
