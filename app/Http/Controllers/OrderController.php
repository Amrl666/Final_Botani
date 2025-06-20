<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        ]);


        if (!empty($data['eduwisata_id'])) {
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
            $jumlah = $data['jumlah'] ?? 1;
            $data['total_harga'] = $produk ? ($produk->price * $jumlah) : 0;
        }

        Order::create($data);
        session()->put('telepon', $data['telepon']);

        $message = !empty($data['eduwisata_id']) 
            ? 'Pesanan eduwisata berhasil direkam.'
            : 'Pesanan produk berhasil direkam.';

        return redirect()->back()->with('success', $message);
    }

    public function index(Request $request)
    {
        $query = Order::with(['produk', 'eduwisata']);

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
        $orders = Order::with(['produk', 'eduwisata'])->latest()->get();

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

        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_pesanan_' . date('Ymd_His') . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), 'xlsx');
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }


    public function riwayatProduk($telepon)
    {
        $orders = Order::with('produk')
            ->where('telepon', $telepon)
            ->whereNotNull('produk_id')
            ->get();
        return view('Frontend.orders.riwayat_produk', compact('orders'));
    }

    public function riwayatEduwisata($telepon)
    {
        $orders = Order::with('eduwisata')
            ->where('telepon', $telepon)
            ->whereNotNull('eduwisata_id')
            ->get();
        return view('Frontend.orders.riwayat_eduwisata', compact('orders'));
    }
}
