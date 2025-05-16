<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Prestasi;
use App\Models\Eduwisata;
use App\Models\Gallery;

class FrontendController extends Controller
{
    public function index()
    {
        $latestBlogs = Blog::latest()->take(3)->get();
        $products = Product::latest()->take(4)->get();
        $prestasi = Prestasi::first();
        $eduwisata = Eduwisata::with('schedules')->first();
        $galleries = Gallery::latest()->take(6)->get();

        return view('frontend.index', compact(
            'latestBlogs',
            'products',
            'prestasi',
            'eduwisata',
            'galleries'
        ));
    }
}