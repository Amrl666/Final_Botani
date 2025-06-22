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

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemesan'      => 'required|string|max:100',
            'telepon'           => 'required|string|max:20',
            'alamat'            => 'nullable|string|max:255',
            'jumlah'            => 'nullable|integer|min:1',
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
            $data['total_harga'] = $produk ? ($produk->price * $jumlah) : 0;
        }

        $order = Order::create($data);

        // Simpan session untuk tracking riwayat user
        session()->put('telepon', $data['telepon']);

        // --- Generate pesan WhatsApp ---
        $nama     = $data['nama_pemesan'];
        $telepon  = $data['telepon'];
        $alamat   = $data['alamat'] ?? '-';
        $jumlah   = $data['jumlah_orang'] ?? $data['jumlah'] ?? 0;
        $tanggal  = $data['tanggal_kunjungan'] ?? '-';
        $harga    = $data['total_harga'];

        $waText = "Halo Admin, saya ingin memesan *$namaItem*:\n" .
                "- Nama: $nama\n" .
                "- No HP: $telepon\n" .
                "- Alamat: $alamat\n" .
                "- Jumlah: $jumlah\n" .
                "- Tanggal: $tanggal\n" .
                "- Total: Rp " . number_format($harga, 0, ',', '.');

        $waNumber = '628553020204'; // <- Ganti dengan nomor admin
        $waUrl = "https://wa.me/$waNumber?text=" . urlencode($waText);

        // ✅ Redirect ke WhatsApp
        return redirect()->away($waUrl);
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

        // Calculate total
        $totalHarga = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Create order
        $order = Order::create([
            'nama_pemesan' => $request->nama_pemesan,
            'telepon' => $request->telepon,
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
        }

        // Clear cart
        CartItem::where('session_id', $sessionId)->delete();

        // Save session for tracking
        session()->put('telepon', $request->telepon);

        // Generate WhatsApp message for multiple products
        $nama = $request->nama_pemesan;
        $telepon = $request->telepon;
        $alamat = $request->alamat;
        $keterangan = $request->keterangan ?? '-';

        $waText = "Halo Admin, saya ingin memesan *Multiple Produk*:\n" .
                "- Nama: $nama\n" .
                "- No HP: $telepon\n" .
                "- Alamat: $alamat\n" .
                "- Keterangan: $keterangan\n\n";

        $waText .= "*Detail Produk:*\n";
        foreach ($cartItems as $item) {
            $waText .= "• {$item->product->name}: {$item->quantity} kg x Rp " . 
                      number_format($item->product->price, 0, ',', '.') . 
                      " = Rp " . number_format($item->subtotal, 0, ',', '.') . "\n";
        }

        $waText .= "\n*Total: Rp " . number_format($totalHarga, 0, ',', '.') . "*";

        $waNumber = '628553020204';
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
            if ($request->jenis == 'produk') $query->whereNotNull('produk_id');
            elseif ($request->jenis == 'eduwisata') $query->whereNotNull('eduwisata_id');
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
                    $sheet->setCellValue('A' . $row, $order->nama_pemesan);
                    $sheet->setCellValue('B' . $row, $order->telepon);
                    $sheet->setCellValue('C' . $row, $order->alamat ?? '-');
                    $sheet->setCellValue('D' . $row, $item->quantity . ' kg');
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
                $jumlah = $order->produk_id
                    ? (($order->jumlah ?? 0) . ' kg')
                    : (($order->jumlah_orang ?? 0) . ' org');

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
}
