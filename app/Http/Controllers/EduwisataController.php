<?php

namespace App\Http\Controllers;

use App\Models\Eduwisata;
use App\Models\EduwisataSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EduwisataController extends Controller
{
    // Admin Methods
    public function index()
    {
        $eduwisatas = Eduwisata::with('schedules')->latest()->paginate(10);
        return view('dashboard.eduwisata.index', compact('eduwisatas'));
    }

    public function create()
    {
        return view('dashboard.eduwisata.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'harga' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('eduwisata_images', 'public');
        }

        Eduwisata::create($validated);

        return redirect()->route('dashboard.eduwisata.index')->with('success', 'Eduwisata created successfully.');
    }

    public function edit(Eduwisata $eduwisata)
    {
        return view('dashboard.eduwisata.edit', compact('eduwisata'));
    }

    public function update(Request $request, Eduwisata $eduwisata)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'harga' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            if ($eduwisata->image) {
                Storage::disk('public')->delete($eduwisata->image);
            }
            $validated['image'] = $request->file('image')->store('eduwisata_images', 'public');
        }

        $eduwisata->update($validated);

        return redirect()->route('dashboard.eduwisata.index')->with('success', 'Eduwisata updated successfully.');
    }

    public function destroy(Eduwisata $eduwisata)
    {
        if ($eduwisata->image) {
            Storage::disk('public')->delete($eduwisata->image);
        }
        $eduwisata->delete();

        return redirect()->route('dashboard.eduwisata.index')->with('success', 'Eduwisata deleted successfully.');
    }

    public function schedule(Eduwisata $eduwisata)
    {
        $schedules = $eduwisata->schedules()->with('eduwisata')->orderBy('date')->get();
        $programs = \App\Models\Eduwisata::all();
        return view('dashboard.eduwisata.schedule', compact('eduwisata', 'schedules', 'programs')); 
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'eduwisata_id' => 'required|exists:eduwisatas,id',
            'date' => 'required|date',
            'time' => 'required',
            'max_participants' => 'required|integer|min:1',
        ]);

        EduwisataSchedule::create($validated);

        return redirect()->route('dashboard.eduwisata.schedule', $validated['eduwisata_id'])
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function destroySchedule(EduwisataSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    // Frontend Methods
    public function index_fr()
    {
        $eduwisatas = Eduwisata::with('schedules')->latest()->paginate(10); // ubah dari ->get() ke ->paginate()
        return view('Frontend.eduwisata.index', compact('eduwisatas'));
    }


    public function schedule_fr()
    {
        $eduwisatas = Eduwisata::with(['schedules' => function($query) {
            $query->where('date', '>=', now())->orderBy('date');
        }])->get();

        return view('Frontend.eduwisata.index', compact('eduwisatas'));
    }
    public function scheduleDetail(Eduwisata $eduwisata)
    {
        $eduwisata->load(['schedules' => function($query) {
            $query->where('date', '>=', now())->orderBy('date');
        }]);
        
        // Ambil data kuota tersisa untuk setiap tanggal dalam bulan ini
        $currentMonth = now()->startOfMonth();
        $nextMonth = now()->addMonth()->startOfMonth();
        
        // Ambil data booking untuk eduwisata ini
        $quotaData = \App\Models\Order::where('eduwisata_id', $eduwisata->id)
            ->where('tanggal_kunjungan', '>=', $currentMonth->toDateString())
            ->where('tanggal_kunjungan', '<', $nextMonth->toDateString())
            ->selectRaw('tanggal_kunjungan, SUM(jumlah_orang) as total_peserta')
            ->groupBy('tanggal_kunjungan')
            ->get();
        
        // Convert ke array dengan format yang benar
        $quotaArray = [];
        foreach ($quotaData as $item) {
            try {
                // Pastikan tanggal_kunjungan adalah string yang valid
                $date = $item->tanggal_kunjungan;
                if ($date instanceof \Carbon\Carbon) {
                    $date = $date->format('Y-m-d');
                } elseif (is_string($date)) {
                    $date = date('Y-m-d', strtotime($date));
                } else {
                    // Skip jika tanggal tidak valid
                    continue;
                }
                
                if ($date && $date !== '1970-01-01') { // Skip invalid dates
                    $quotaArray[$date] = max(0, 15 - $item->total_peserta);
                }
            } catch (\Exception $e) {
                Log::error('Error processing quota data: ' . $e->getMessage(), [
                    'item' => $item,
                    'eduwisata_id' => $eduwisata->id
                ]);
                continue;
            }
        }
        
        // Fallback: jika tidak ada data, set array kosong
        if (empty($quotaArray)) {
            $quotaArray = [];
        }
        
        // Ambil data jadwal yang sudah penuh (15 orang per hari)
        $fullDates = [];
        foreach ($quotaArray as $date => $quota) {
            if ($quota <= 0) {
                $fullDates[] = $date;
            }
        }
        

        
        return view('Frontend.eduwisata.schedule', compact('eduwisata', 'fullDates', 'quotaArray'));
    }
    
    // API untuk mendapatkan data kuota real-time
    public function getQuotaData(Eduwisata $eduwisata)
    {
        $currentMonth = now()->startOfMonth();
        $nextMonth = now()->addMonth()->startOfMonth();
        
        $quotaData = \App\Models\Order::where('eduwisata_id', $eduwisata->id)
            ->where('tanggal_kunjungan', '>=', $currentMonth->toDateString())
            ->where('tanggal_kunjungan', '<', $nextMonth->toDateString())
            ->selectRaw('tanggal_kunjungan, SUM(jumlah_orang) as total_peserta')
            ->groupBy('tanggal_kunjungan')
            ->get();
        
        $quotaArray = [];
        foreach ($quotaData as $item) {
            try {
                // Pastikan tanggal_kunjungan adalah string yang valid
                $date = $item->tanggal_kunjungan;
                if ($date instanceof \Carbon\Carbon) {
                    $date = $date->format('Y-m-d');
                } elseif (is_string($date)) {
                    $date = date('Y-m-d', strtotime($date));
                } else {
                    // Skip jika tanggal tidak valid
                    continue;
                }
                
                if ($date && $date !== '1970-01-01') { // Skip invalid dates
                    $quotaArray[$date] = max(0, 15 - $item->total_peserta);
                }
            } catch (\Exception $e) {
                Log::error('Error processing quota data in API: ' . $e->getMessage(), [
                    'item' => $item,
                    'eduwisata_id' => $eduwisata->id
                ]);
                continue;
            }
        }
        
        // Fallback: jika tidak ada data, set array kosong
        if (empty($quotaArray)) {
            $quotaArray = [];
        }
        
        $fullDates = [];
        foreach ($quotaArray as $date => $quota) {
            if ($quota <= 0) {
                $fullDates[] = $date;
            }
        }
        
        return response()->json([
            'quotaData' => $quotaArray,
            'fullDates' => $fullDates
        ]);
    }

}