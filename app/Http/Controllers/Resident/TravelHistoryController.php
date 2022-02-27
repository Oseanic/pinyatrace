<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use App\Models\TravelHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TravelHistoryController extends Controller
{
    public function index()
    {
        $history = TravelHistory::where('user_id','=',Auth::user()->id)->orderBy('updated_at','DESC')->get();
        return view('pages.resident.travel.index', compact('history'));
    }
}
