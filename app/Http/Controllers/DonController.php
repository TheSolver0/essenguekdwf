<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonController extends Controller
{
    public function index()
    {
        // On retournera une vue "don/event.blade.php"
        return view('don.event');
    }
}
