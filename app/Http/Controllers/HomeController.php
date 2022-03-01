<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\CovidCase;
use Illuminate\Http\Request;
use App\Models\TravelHistory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cases = CovidCase::all();
        $visitortotal = TravelHistory::count();
        $latest = TravelHistory::where('user_id','=',Auth::user()->id)->latest()->first();

        
        // $max = CovidCase::distinct()->get(['address']);
        $top = CovidCase::select('address')->where('status','=','Positive')
        ->selectRaw('COUNT(*) AS count')
        ->groupBy('address')
        ->orderByDesc('count')
        ->limit(5)
        ->get();
        $areas = CovidCase::select('address')->where('status','=','Positive')
        ->selectRaw('COUNT(*) AS count')->groupBy('address')->orderByDesc('count')->get();
        //$residentArea = $areas->where('address','=',Auth::user()->profile->barangay)->first();
        $active = $cases->where('status', 'Positive')->count();
        $recovered = $cases->where('status', 'Recovered')->count();
        $mortality = $cases->where('status', 'Died')->count();
        $total = $cases->count();
        $user = Profile::where('user_id', '=', Auth::user()->id)->first();
        
        if($user === null){
            return redirect()->route('profile.create')->with('message', 'Profile has not been created yet', compact(['cases', 'active', 'recovered', 'mortality', 'total', 'top', 'visitortotal', 'latest']));
            
        }
        return view('pages.resident.dashboard.index', compact(['cases', 'active', 'recovered', 'mortality', 'total', 'top', 'visitortotal', 'latest']));
    }
}
