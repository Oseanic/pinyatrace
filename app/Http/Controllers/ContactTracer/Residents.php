<?php

namespace App\Http\Controllers\ContactTracer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TravelHistory;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Residents extends Controller
{
    public function index(){

        $residents = User::with('profile')->get();
        // dd($residents);
        return view('pages.contact_tracer.residents.index', compact('residents'));
    }

    public function travel($id){

        $user = User::where('id','=',$id)->with('profile')->first();
        $latest = TravelHistory::where('user_id','=',$id)->latest()->first();
        $dateTime = Carbon::now()->isoFormat('dddd D, YYYY - hh:mm a');
        $history = TravelHistory::where('user_id','=',$id)->orderBy('updated_at','DESC')->get();
        return view('pages.contact_tracer.residents.history', compact(['user','history', 'latest', 'dateTime']));


    }
}
