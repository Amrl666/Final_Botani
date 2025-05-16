<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Admin Methods
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        return view('dashboard.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('dashboard.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
        ]);

        $validated['image'] = $request->file('image')->store('gallery_images', 'public');

        Gallery::create($validated);

        return redirect()->route('dashboard.gallery.index')->with('success', 'Gallery item created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        return view('dashboard.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('gallery_images', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('dashboard.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('dashboard.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }

    // Frontend Method
    public function index_fr()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('frontend.gallery.index', compact('galleries'));
    }
}