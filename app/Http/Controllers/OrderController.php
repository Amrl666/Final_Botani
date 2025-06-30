<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Eduwisata;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemesan'      => 'required|string|max:100',
            'telepon'           => 'nullable|string|max:20',
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
            
            // Check if quantity is valid based on min_increment (only if min_increment > 0)
            if ($produk && $produk->min_increment > 0) {
                // Use a more robust method to avoid floating-point precision issues
                $remainder = fmod($jumlah, $produk->min_increment);
                if (abs($remainder) > 0.001) { // Allow for small floating-point errors
                    return back()->with('error', "Jumlah harus kelipatan {$produk->min_increment} {$produk->unit}.");
                }
            }
            
            $data['total_harga'] = $produk ? ($produk->price * $jumlah) : 0;
        }

        // Ambil nomor telepon dari customer login jika ada
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $data['telepon'] = $customer->phone;
            session()->put('customer_id', $customer->id);
        } else {
            $data['telepon'] = $data['telepon'] ?? null;
            session()->put('customer_phone', $data['telepon']);
        }

        $order = Order::create($data);

        // Setelah order dibuat, redirect ke halaman pembayaran
        return redirect()->route('payment.show', $order->id);
    }

    // New method for checkout from cart
    public function checkoutFromCart(Request $request)
    {
        $request->validate([
            'nama_pemesan'      => 'required|string|max:100',
            'telepon'           => 'nullable|string|max:20',
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

        // Calculate total
        $totalHarga = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Ambil nomor telepon dari customer login jika ada
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $telepon = $customer->phone;
            session()->put('customer_id', $customer->id);
        } else {
            $telepon = $request->telepon;
            session()->put('customer_phone', $telepon);
        }

        // Create order
        $order = Order::create([
            'nama_pemesan' => $request->nama_pemesan,
            'telepon' => $telepon,
            'alamat' => $request->alamat,
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
            'keterangan' => $request->keterangan
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price_per_unit' => $cartItem->product->price,
                'subtotal' => $cartItem->quantity * $cartItem->product->price
            ]);

            // Reduce stock
            $cartItem->product->updateStock(
                -$cartItem->quantity,
                'out',
                'Pesanan #' . $order->id,
                'order_' . $order->id
            );
        }

        // Clear cart
        CartItem::where('session_id', $sessionId)->delete();

        // Setelah order dibuat, redirect ke halaman pembayaran
        return redirect()->route('payment.show', $order->id);
    }

    public function index(Request $request)
    {
        $query = Order::with(['produk', 'eduwisata', 'orderItems.product', 'delivery']);

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
        $request->validate(['status' => 'required|in:menunggu,disetujui,ditolak,selesai,menunggu_konfirmasi']);
        
        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);
        
        // Send WhatsApp notification for status changes
        if ($oldStatus !== $request->status) {
            $this->sendStatusNotification($order, $request->status);
        }
        
        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }

    protected function sendStatusNotification($order, $status)
    {
        $statusMessages = [
            'disetujui' => 'Pesanan Anda telah disetujui dan sedang diproses.',
            'ditolak' => 'Maaf, pesanan Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.',
            'selesai' => 'Pesanan Anda telah selesai. Terima kasih telah berbelanja!',
            'menunggu_konfirmasi' => 'Pembayaran Anda sedang diverifikasi. Kami akan segera mengkonfirmasi.',
        ];

        if (isset($statusMessages[$status])) {
            $message = "🔄 *Update Status Pesanan*\n\n";
            $message .= "Halo {$order->nama_pemesan},\n";
            $message .= $statusMessages[$status] . "\n\n";
            $message .= "Status: " . ucfirst($status) . "\n";
            $message .= "Total: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n\n";
            $message .= "Terima kasih telah berbelanja di Kelompok Tani Winongo Asri! 🌱";

            // Use WhatsApp service if available
            if (class_exists('\App\Services\WhatsAppService')) {
                $whatsappService = app('\App\Services\WhatsAppService');
                $whatsappService->sendText($order->telepon, $message);
            }
        }
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

    public function riwayatProduk()
    {
        $phone = null;
        
        // Check if customer is logged in
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $phone = $customer->phone;
        } else {
            // Check session for phone number
            $phone = session('customer_phone');
        }

        if (!$phone) {
            return redirect()->route('login.wa')->with('error', 'Silakan login terlebih dahulu untuk melihat riwayat.');
        }

        $orders = Order::with(['orderItems.product', 'produk'])
            ->where('telepon', $phone)
            ->where(function ($query) {
                $query->whereHas('orderItems')
                      ->orWhereNotNull('produk_id');
            })
            ->latest()
            ->get();

        return view('Frontend.orders.riwayat_produk', compact('orders'));
    }

    public function riwayatEduwisata()
    {
        $phone = null;
        
        // Check if customer is logged in
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $phone = $customer->phone;
        } else {
            // Check session for phone number
            $phone = session('customer_phone');
        }

        if (!$phone) {
            return redirect()->route('login.wa')->with('error', 'Silakan login terlebih dahulu untuk melihat riwayat.');
        }

        $orders = Order::with(['eduwisata' => function($query) {
                $query->select('id', 'name', 'harga');
            }])
            ->where('telepon', $phone)
            ->whereNotNull('eduwisata_id')
            ->latest()
            ->get();
            
        return view('Frontend.orders.riwayat_eduwisata', compact('orders'));
    }

    public function orderNowForm($productId, Request $request)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $jumlah = $request->query('jumlah', $product->min_increment); // default to min_increment
        
        // Get customer data if logged in
        $customer = null;
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
        }
        
        return view('Frontend.product.order_now', compact('product', 'jumlah', 'customer'));
    }

    public function checkoutForm()
    {
        $sessionId = session()->getId();
        $cartItems = CartItem::with('product')
            ->where('session_id', $sessionId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('Frontend.checkout.form', compact('cartItems', 'total'));
    }
}
