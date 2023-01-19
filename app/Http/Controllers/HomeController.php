<?php

namespace App\Http\Controllers;

use App\Models\URL;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) 
    {
        // fetch urls
        $urls = URL::all();

        // return view with urls
        return view('welcome', [ 'urls' => $urls ]);
    }
}
