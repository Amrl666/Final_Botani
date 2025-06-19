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
            'nama_pemesan' => 'required',
            'telepon' => 'required',
            'jumlah_orang' => 'nullable|integer|min:1',
            'produk_id' => 'nullable|exists:products,id',
            'eduwisata_id' => 'nullable|exists:eduwisatas,id',
        ]);

        if (!empty($data['eduwisata_id'])) {
            $jumlah = $data['jumlah_orang'] ?? 0;
            if ($jumlah >= 20) {
                $harga = 10000;
            } elseif ($jumlah >= 10) {
                $harga = 12000;
            } else {
                $harga = 14000;
            }
            $data['total_harga'] = $harga * $jumlah;
        } elseif (!empty($data['produk_id'])) {
            $produk = Product::find($data['produk_id']);
            $data['total_harga'] = $produk ? $produk->price : 0;
        }


        Order::create($data);
        session()->put('telepon', $data['telepon']);
        return redirect()->back()->with('success', 'Pesanan berhasil direkam.');
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

        $orders = $query->latest()->get();
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

        $headers = ['Nama', 'Telepon', 'Jumlah Orang', 'Produk/Wisata', 'Total Harga', 'Status', 'Tanggal'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 2;
        foreach ($orders as $order) {
            $jenis = $order->produk->name ?? ($order->eduwisata->name ?? '-');
            $tanggal = ($order->created_at instanceof \DateTimeInterface)
                ? $order->created_at->format('Y-m-d') : '-';

            $sheet->setCellValue('A' . $row, $order->nama_pemesan);
            $sheet->setCellValue('B' . $row, $order->telepon);
            $sheet->setCellValue('C' . $row, $order->jumlah_orang);
            $sheet->setCellValue('D' . $row, $jenis);
            $sheet->setCellValue('E' . $row, $order->total_harga);
            $sheet->setCellValue('F' . $row, ucfirst($order->status));
            $sheet->setCellValue('G' . $row, $tanggal);
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
        return view('frontend.orders.riwayat_produk', compact('orders'));
    }

    public function riwayatEduwisata($telepon)
    {
        $orders = Order::with('eduwisata')
            ->where('telepon', $telepon)
            ->whereNotNull('eduwisata_id')
            ->get();
        return view('frontend.orders.riwayat_eduwisata', compact('orders'));
    }
}
