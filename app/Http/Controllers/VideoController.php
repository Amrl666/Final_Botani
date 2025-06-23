<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:512000', // max 500MB
            'description' => 'nullable|string',
        ], [
            'title.required' => 'Judul wajib diisi!',
            'video.required' => 'format harus mp4,ogx,oga,ogv,ogg,webm!',
            'video.url' => 'Format URL tidak valid!',
        ]);

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('gallery_video', 'public');
        } else {
            return back()->with('error', 'File video gagal diupload.')->withInput();
        }

        // Pastikan hanya path relatif yang disimpan
        $validated['video'] = ltrim(str_replace('public/', '', $validated['video']), '/');

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
            'video' => 'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm|max:512000',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('video')) {
            // Hapus file lama jika ada
            if ($video->video && Storage::disk('public')->exists($video->video)) {
                Storage::disk('public')->delete($video->video);
            }
            $validated['video'] = $request->file('video')->store('gallery_video', 'public');
            $validated['video'] = ltrim(str_replace('public/', '', $validated['video']), '/');
        } else {
            unset($validated['video']); // Jangan update field video jika tidak ada file baru
        }

        $video->update($validated);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video updated successfully.');
    }

    /**
     * Menghapus video.
     */
    public function destroy(Video $video)
    {
        // Hapus file video dari storage jika ada
        if ($video->video && Storage::disk('public')->exists($video->video)) {
            Storage::disk('public')->delete($video->video);
        }
        $video->delete();
        return redirect()->route('dashboard.videos.index')->with('success', 'Video deleted successfully.');
    }

    /**
     * Menampilkan video di halaman frontend.
     */
    public function index_fr()
    {
        $videos = Video::latest()->paginate(8);
        return view('Frontend.videos.index', compact('videos'));
    }
}
