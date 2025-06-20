<?php

namespace App\Http\Controllers;

use App\Models\Eduwisata;
use App\Models\EduwisataSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $schedules = $eduwisata->schedules()->orderBy('date')->get();
        return view('dashboard.eduwisata.schedule', compact('eduwisata', 'schedules'));
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

        return view('Frontend.eduwisata.schedule', compact('eduwisatas'));
    }
    public function scheduleDetail(Eduwisata $eduwisata)
    {
        $eduwisata->load('schedules');
        return view('Frontend.eduwisata.schedule', compact('eduwisata'));
    }

}