<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    // Admin Methods
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('dashboard.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('dashboard.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url',
            'description' => 'nullable',
        ]);

        Video::create($validated);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video added successfully.');
    }

    public function edit(Video $video)
    {
        return view('dashboard.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url',
            'description' => 'nullable',
        ]);

        $video->update($validated);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('dashboard.videos.index')->with('success', 'Video deleted successfully.');
    }

    // Frontend Method
    public function index_fr()
    {
        $videos = Video::latest()->paginate(8);
        return view('frontend.videos.index', compact('videos'));
    }
}