<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Menampilkan semua video (Admin Panel).
     */
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('dashboard.videos.index', compact('videos'));
    }

    /**
     * Form untuk menambahkan video baru.
     */
    public function create()
    {
        return view('dashboard.videos.create');
    }

    /**
     * Menyimpan video baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'title' => 'required|string|max:255',
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm:',
            'description' => 'nullable|string',
        ], [
            'title.required' => 'Judul wajib diisi!',
            'video.required' => 'format harus mp4,ogx,oga,ogv,ogg,webm!',
            'video.url' => 'Format URL tidak valid!',
        ]);

         $validated['video'] = $request->file('video')->store('gallery_video', 'public');

        Video::create($validated);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video added successfully.');
    }

    /**
     * Form untuk mengedit video.
     */
    public function edit(Video $video)
    {
        return view('dashboard.videos.edit', compact('video'));
    }

    /**
     * Memperbarui video.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'title' => 'required|string|max:255',
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm:',
            'description' => 'nullable|string',
        ]);

        $video->update($validated);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video updated successfully.');
    }

    /**
     * Menghapus video.
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('dashboard.videos.index')->with('success', 'Video deleted successfully.');
    }

    /**
     * Menampilkan video di halaman frontend.
     */
    public function index_fr()
    {
        $videos = Video::latest()->paginate(8);
        return view('frontend.videos.index', compact('videos'));
    }
}
