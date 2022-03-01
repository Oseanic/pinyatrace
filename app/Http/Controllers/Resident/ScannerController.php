<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\TravelHistory;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ScannerController extends Controller
{
    public function index()
    {
        $latest = TravelHistory::where('user_id','=',Auth::user()->id)->latest()->first();

        if( Auth::user()->profile == null ){
            return redirect()->route('profile.create')->with('danger', 'Profile has not been created yet');
        }

        return view('pages.resident.qr-code.scanner', compact('latest'));
    }

    public function hasScanned($id)
    {
        $latest = TravelHistory::where('user_id','=',Auth::user()->id)->latest()->first();
        $establishment = Establishment::where('id','=',$id)->with('information')->first();
        $dateTime = Carbon::now()->isoFormat('dddd D, YYYY - hh:mm a');
        return view('pages.resident.qr-code.scanner', compact(['establishment', 'dateTime', 'latest']));
    }

    public function camera()
    {
        return view('pages.resident.qr-code.camera');
    }
}
