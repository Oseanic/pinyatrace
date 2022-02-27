<?php

namespace App\Http\Controllers\ContactTracer;

use App\Models\CovidCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactTracerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:contact_tracer');
    }

    public function index(){
        $cases = CovidCase::all();
        $top = CovidCase::select('address')->where('status','=','Positive')
        ->selectRaw('COUNT(*) AS count')
        ->groupBy('address')
        ->orderByDesc('count')
        ->get();
        $active = $cases->where('status', 'Positive')->count();
        $recovered = $cases->where('status', 'Recovered')->count();
        $mortality = $cases->where('status', 'Died')->count();
        $total = $cases->count();
        return view('pages.contact_tracer.dashboard.index', compact(['cases', 'active', 'recovered', 'mortality', 'total', 'top']));
    }
}
