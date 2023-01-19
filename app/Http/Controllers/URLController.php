<?php

namespace App\Http\Controllers;

use App\Models\URL;
use Illuminate\Http\Request;

class URLController extends Controller
{
    public function handleRedirect(Request $request) 
    {
        $path = substr($request->path(), 10);
        $url = URL::where('custom_slug', $path)->firstOrFail();

        dd($url->redirect_to);
    }
}
