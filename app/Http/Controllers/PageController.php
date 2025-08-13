<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() {
        return view('home');
    }

    public function about() {
        return view('about');
    }

    public function activity() {
        return view('activity');
    }

    public function media() {
        return view('media');
    }

    public function implantation() {
        return view('implantation');
    }

    public function contact() {
        return view('contact');
    }
}