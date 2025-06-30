<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerijinanControler extends Controller
{
    public function index_fr()
    {
        return view('Frontend.perijinan.index');
    }

    public function showPdf()
    {
        $pdfPath = public_path('pdf/perizinan.pdf');
        $htmlPath = public_path('pdf/perizinan.html');
        
        // Cek file PDF terlebih dahulu
        if (file_exists($pdfPath)) {
            return response()->file($pdfPath);
        }
        
        // Jika PDF tidak ada, gunakan HTML sebagai fallback
        if (file_exists($htmlPath)) {
            return response()->file($htmlPath);
        }
        
        // Jika kedua file tidak ada, tampilkan pesan error
        abort(404, 'File dokumen perizinan tidak ditemukan. Silakan upload file PDF ke direktori public/pdf/perizinan.pdf');
    }
}
