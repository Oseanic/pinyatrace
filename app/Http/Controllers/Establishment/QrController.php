<?php

namespace App\Http\Controllers\Establishment;

use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\TravelHistory;
use App\Models\Contact;
use Illuminate\Support\Carbon;
use App\Models\HealthDeclaration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function in($id)
    {

        $establishment = Establishment::where('id','=',$id)->with('information')->first();
        $dateTime = Carbon::now()->isoFormat('dddd D, YYYY - hh:mm a');
        $travel = TravelHistory::where('out','=',null)->orWhere('establishment_id','=',$id)->orWhere('user_id','=',Auth::user()->id)->latest()->first();

        //if($travel->out == null){
        //$travel->update([
            //'out' => Carbon::now()->isoFormat('hh:mm a')
        //]);

        //return redirect()->route('scanner')->with('out', sprintf('Thank you for visiting %s', $travel->establishment_name));
        //}
        
        //else{
        TravelHistory::create([
            'user_id' => Auth::user()->id,
            'res_name' => Auth::user()->profile->getFullname(),
            'date' =>  Carbon::now()->format('Y-m-d'),
            'in'   => Carbon::now()->isoFormat('hh:mm a'),
            'role' => Auth::user()->profile->role,
            'email' => Auth::user()->email,
            'id_number' => Auth::user()->profile->id_number,
            'cp_number' => Auth::user()->profile->cp_number,
            'tel_number' => Auth::user()->profile->tel_number,
            'emergency_contact' => Auth::user()->contact->emergency_contact,
            'ec_cp_number' => Auth::user()->contact->ec_cp_number,
            'address' => Auth::user()->profile->getFullAddress(),
            'establishment_id' => $establishment->id,
            'establishment_name' => $establishment->information->company_name,
            'establishment_address' => $establishment->information->company_address
        ]);

        if($establishment->information->health_dec_status == "Enabled"){
            return redirect()->route('has.scanned', $id)->with('health', 'Kindly answer this health declaration form')->with(compact(['establishment', 'dateTime']));
        }

        else{
            return redirect()->route('scanner')->with('enter', 'Thank you for scanning!');
        }
        
        //return view('pages.resident.qr-code.scanner', )->with('show');
        //}
    }

    public function out($id)
    {
        $travel = TravelHistory::where('out','=',null)->orWhere('establishment_id','=',$id)->orWhere('user_id','=',Auth::user()->id)->latest()->first();

        $travel->update([
            'out' => Carbon::now()->isoFormat('hh:mm a')
        ]);

        return redirect()->route('scanner')->with('out', sprintf('Thank you for visiting %s', $travel->establishment_name));
    }

    public function healthStore(Request $request, $id)
    {   
        $travel = TravelHistory::where('out','=',null)->orWhere('establishment_id','=',$id)->orWhere('user_id','=',Auth::user()->id)->latest()->first();


        if($request->temp >= 37.5){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);
            return redirect()->route('scanner')->with('danger', sprintf("You're temperature is %s", $request->temp));

        }
        elseif($request->q1 === 'Yes'){
            
            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));

        }
        elseif($request->q2 === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->fever === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->cough === 'Yes'){
            
            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->runny_nose === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->sore_throat === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->shortness_of_breath === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));

        }
        else{

            HealthDeclaration::create([
                'est_id' => $id,
                'user_id' => Auth::user()->id,
                'temp' => $request->temp,
                'q1' => $request->q1,
                'q2' => $request->q2,
                'fever' => $request->fever,
                'cough' => $request->cough,
                'runny_nose' => $request->runny_nose,
                'sore_throat' => $request->sore_throat,
                'shortness_of_breath' => $request->shortness_of_breath
            ]);

            return redirect()->route('scanner')->with('enter', 'You may enter!');
        }
    }
}
