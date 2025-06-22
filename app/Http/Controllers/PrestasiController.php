<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    // Admin Methods
    public function index()
    {
        $prestasis = Prestasi::latest()->paginate(10);
        return view('dashboard.prestasi.index', compact('prestasis'));
    }

    public function create()
    {
        return view('dashboard.prestasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('prestasi_images', 'public');
        }

        Prestasi::create($validated);

        return redirect()->route('dashboard.prestasi.index')->with('success', 'Prestasi created successfully.');
    }

    public function edit(Prestasi $prestasi)
    {
        return view('dashboard.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($prestasi->image) {
                Storage::disk('public')->delete($prestasi->image);
            }
            $validated['image'] = $request->file('image')->store('prestasi_images', 'public');
        }

        $prestasi->update($validated);

        return redirect()->route('dashboard.prestasi.index')->with('success', 'Prestasi updated successfully.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->image) {
            Storage::disk('public')->delete($prestasi->image);
        }
        $prestasi->delete();

        return redirect()->route('dashboard.prestasi.index')->with('success', 'Prestasi deleted successfully.');
    }

    // Frontend Method
    public function index_fr()
    {
        $prestasi = Prestasi::latest()->paginate(12);
        return view('Frontend.prestasi.index', compact('prestasi'));
    }

    
}