<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function index()
    {
        return view('pages.sample.index');
    }

    public function view()
    {
        $hello = "success";
        dd($hello);

        return view('pages.sample.view');
    }
}
