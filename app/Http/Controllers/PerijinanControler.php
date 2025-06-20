<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerijinanControler extends Controller
{
    public function index_fr()
    {
        return view('Frontend.perijinan.index');
    }
}
