<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index()
    {
        /* Remove the command below, used for testing */
        $output = Artisan::call('inspire');
        $quote = trim(str_replace(['[0;32m', '[0m'], '', Artisan::output()));

        return view('home.index', ['quote' => $quote]);
    }
}
