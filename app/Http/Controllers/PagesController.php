<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function index() {
        $title = 'NMS Tracking Application';
        return view('pages.index')->with('title', $title);
    }

    public function about() {
        $aboutApp = 'This app is for tracking issue';
        return view('pages.about')->with('aboutApp', $aboutApp);
    }
}
