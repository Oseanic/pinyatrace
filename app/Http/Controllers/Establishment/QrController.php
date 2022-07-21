<?php

namespace App\Http\Controllers\Establishment;

use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\TravelHistory;
use App\Models\Attendance;
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
        
        $date = Carbon::now();
        $student = Attendance::where('user_id', '=', Auth::user()->id)->latest()->first();
        $scanverify = TravelHistory::where('user_id', '=', Auth::user()->id)->latest()->first();
        $verify = Auth::user()->profile->role;

        //dd($scanverify);

        if($scanverify == null){
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
        }

        elseif($scanverify != null){
                if($scanverify->date != Carbon::today()->format('Y-m-d')){
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
                }

                elseif($scanverify->date = Carbon::today()->format('Y-m-d')){
                    TravelHistory::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                        'user_id' => Auth::user()->id,
                        'res_name' => Auth::user()->profile->getFullname(),
                        'date' =>  Carbon::now()->format('Y-m-d'),
                        'in'   => Carbon::now()->isoFormat('hh:mm a'),
                        'role' => Auth::user()->profile->role,
                        'id_number' => Auth::user()->profile->id_number,
                    ]);
                }
        }
               
        if($verify != "Visitor"){         
            if($student == null){
                Attendance::create([
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
                    'image' => "/img/Logo.png",
                    'section' => Auth::user()->profile->getfullsection(),
                ]);

                if($establishment->information->health_dec_status == "Enabled"){
                    return redirect()->route('has.scanned', $id)->with('health', 'Kindly answer this health declaration form')->with(compact(['establishment', 'dateTime']));
                }
        
                else{
                    return redirect()->route('scanner')->with('enter', 'Thank you for scanning! Welcome!');
                }
            }
            
            elseif($student != null){                       
                if($student->date != Carbon::today()->format('Y-m-d')) {
                    Attendance::create([
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
                        'image' => "/img/Logo.png",
                        'section' => Auth::user()->profile->getfullsection(),
                    ]);

                    if($establishment->information->health_dec_status == "Enabled"){
                        return redirect()->route('has.scanned', $id)->with('health', 'Kindly answer this health declaration form')->with(compact(['establishment', 'dateTime']));
                    }
            
                    else{
                        return redirect()->route('scanner')->with('enter', 'Thank you for scanning! Welcome!');
                    }
                }

                elseif($student->date = Carbon::today()->format('Y-m-d')){                     
                        if($student->out == null){
                             Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                            'date' =>  Carbon::now()->format('Y-m-d'),
                            'out'   => Carbon::now()->isoFormat('hh:mm a'),
                            'role' => Auth::user()->profile->role,
                            'id_number' => Auth::user()->profile->id_number,
                            'section' => Auth::user()->profile->getfullsection(),
                            ]);     
                            
                            return redirect()->route('scanner')->with('out', 'Thank you for scanning out!');
                        }
                        
                        if($student->out != null){
                            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                           'date' =>  Carbon::now()->format('Y-m-d'),
                           'in'   => Carbon::now()->isoFormat('hh:mm a'),
                           'out' => null,
                           'role' => Auth::user()->profile->role,
                           'id_number' => Auth::user()->profile->id_number,
                           'section' => Auth::user()->profile->getfullsection(),
                           ]);

                            if($establishment->information->health_dec_status == "Enabled"){
                                return redirect()->route('has.scanned', $id)->with('health', 'Kindly answer this health declaration form')->with(compact(['establishment', 'dateTime']));
                            }
                    
                            else{
                                return redirect()->route('scanner')->with('enter', 'Thank you for scanning! Welcome!');
                            }  
                       }
                }
            }
        }
       

        if($establishment->information->health_dec_status == "Enabled"){
            return redirect()->route('has.scanned', $id)->with('health', 'Kindly answer this health declaration form')->with(compact(['establishment', 'dateTime']));
        }

        else{
            return redirect()->route('scanner')->with('reason', 'Please Input Reason for Visiting');
        }
        
        //return view('pages.resident.qr-code.scanner', )->with('show');
        //}
    }

    public function updatereason(Request $request)
    {
        try{
                TravelHistory::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'reason_visit' => $request->reason_visit,
            ]);

            return redirect()->route('scanner')->with('enter', 'Thank you for scanning!');
        }
        catch (\Illuminate\Database\QueryException $exception) {
       
            $errorInfo = $exception->errorInfo;
       
            return dd($errorInfo);
       
        }
       
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

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
                ]);

            return redirect()->route('scanner')->with('danger', sprintf("You're temperature is %s", $request->temp));

        }
        elseif($request->q1 === 'Yes'){
            
            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
                ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));

        }
        elseif($request->q2 === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
                ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->fever === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
                ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->cough === 'Yes'){
            
            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
                ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->runny_nose === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
                ]);

            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->sore_throat === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
                ]);
            return redirect()->route('scanner')->with('danger', sprintf("You are not allowed to enter"));


        }
        elseif($request->shortness_of_breath === 'Yes'){

            $travel->update([
                'in' => "Not allowed",
                'out' => "Not allowed"
            ]);

            Attendance::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'date' =>  Carbon::now()->format('Y-m-d'),
                'in'   => "Not allowed",
                'out' => "Not allowed",
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

            TravelHistory::where('user_id','=', Auth::user()->id)->where('date','=', Carbon::today())->update([
                'reason_visit' => $request->reason_visit,
            ]);

            return redirect()->route('scanner')->with('enter', 'You may enter!');
        }
    }
}
