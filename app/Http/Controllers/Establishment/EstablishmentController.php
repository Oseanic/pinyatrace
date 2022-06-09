<?php

namespace App\Http\Controllers\Establishment;

use App\Models\CovidCase;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TravelHistory;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EstablishmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:establishment');
    }

    public function index()
    {
        $cases = CovidCase::all();
        $now = Carbon::now()->format('Y-m-d');
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $month = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
        $visitortotal = TravelHistory::count();
        $visitornow = TravelHistory::whereDate('date', $now)->get()->count();
        $visitorweek = TravelHistory::whereBetween('date', $week)->get()->count();
        $visitormonth = TravelHistory::whereBetween('date', $month)->get()->count();
        $notallowed = TravelHistory::where('in', '=', 'Not allowed')->get()->count();


        
        //dd($visitormonth);
        //dd($now);
       
        $top = CovidCase::select('address')->where('status','=','Positive')
        ->selectRaw('COUNT(*) AS count')
        ->groupBy('address')
        ->orderByDesc('count')
        ->limit(5)
        ->get();
        $active = $cases->where('status', 'Positive')->count();
        $recovered = $cases->where('status', 'Recovered')->count();
        $mortality = $cases->where('status', 'Died')->count();
        $total = $cases->count();

        $est = Information::where('est_id', '=', Auth::guard('establishment')->user()->id)->first();
        if($est === null){
            return redirect()->route('information.create')->with('message', 'Kindly create your company information', compact(['cases', 'active', 'recovered', 'mortality', 'total', 'top', 'visitortotal']));
        }

        return view('pages.establishment.dashboard.index', compact(['cases', 'active', 'recovered', 'mortality', 'total', 'top', 'visitortotal', 'visitornow', 'visitorweek', 'visitormonth', 'notallowed']));
    }
}
