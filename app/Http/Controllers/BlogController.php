<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // Admin Methods
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('dashboard.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('dashboard.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog_images', 'public');
        }

        Blog::create($validated);

        return redirect()->route('dashboard.blog.index')->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        return view('dashboard.blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('dashboard.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $validated['image'] = $request->file('image')->store('blog_images', 'public');
        }

        $blog->update($validated);

        return redirect()->route('dashboard.blog.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();

        return redirect()->route('dashboard.blog.index')->with('success', 'Blog deleted successfully.');
    }

    // Frontend Methods
    public function index_fr()
    {
        $blogs = Blog::latest()->paginate(6);
        return view('frontend.blog.index', compact('blogs'));
    }

    public function show_fr(Blog $blog)
    {
        return view('frontend.blog.show', compact('blog'));
    }
}