<?php

namespace App\Http\Controllers\Establishment;

use Illuminate\Http\Request;
use App\Models\TravelHistory;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

class Visitors extends Controller
{
    public function index()
    {
        
        $date = "Latest to Oldest"; 
        $dt = "Latest to Oldest";
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]; 
        $visitortotal = TravelHistory::count();
       
        //$resident = User::where('id','=',Auth::user()->id)->with('contact')->get();
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->orderBy('updated_at','DESC')->paginate(15);
       
        //dd($contact);
        return view('pages.establishment.visitors.index', compact('visitors', 'week', 'date', 'dt'));  
       
    }


    public function pdfall()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->visitorpdf());
        return $pdf->stream();
        //dd($pdf);
    }
    
    public function visitorpdf()
    {
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->orderBy('created_at','DESC')->paginate(1000);
        $dt = "Latest to Oldest";

        return view('pages.establishment.visitors.pdf', compact('visitors', 'dt'));  
            //dd($output);
    }

    public function pdfnotallowed()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->notallowedpdf());
        return $pdf->stream();
        //dd($pdf);
    }

    public function notallowedpdf()
    {
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->where('in', '=', 'Not allowed')->orderBy('created_at','DESC')->paginate(1000);
        $dt = "Not Allowed";

        return view('pages.establishment.visitors.pdf', compact('visitors', 'dt'));  
            //dd($output);
    }


    public function printrange(Request $request)
    {   

        $range = [new Carbon($request->date1), new Carbon($request->date2)];

        $start = Carbon::parse($request->date1)->format('M, d Y');
        $end =  Carbon::parse($request->date2)->format('M, d Y');
        $dt = $start." - ".$end; 
        
        if($request->date1 > $request->date2){
            return redirect()->route('visitors')->with('error', 'Start Date cannot be greater than End date');
        }

        else{
            $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $range)->orderBy('created_at','DESC')->paginate(1000);
            $show = TravelHistory::whereBetween('date', $range)->get();
    
            //dd($visitors);
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView('pages.establishment.visitors.pdf', compact('show', 'visitors', 'dt'));
            return $pdf->stream();
        }
    }

    public function printsearch(Request $request)
    {
        $date = Carbon::now();
        $dt = Carbon::parse($request->date)->format('M, d Y');
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->where('date', '=', $request->date)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::where('date', '=', $request->date)->get();

        //dd($visitors);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.visitors.pdf', compact('show', 'visitors', 'dt'));
        return $pdf->stream();
    }

    public function printweek(Request $request)
    {
        
        $week = [Carbon::parse($request->week)->startOfWeek(), Carbon::parse($request->week)->endOfWeek()]; 
        $start = Carbon::parse($request->week)->startOfWeek()->format('M, d Y');
        $end =  Carbon::parse($request->week)->endOfWeek()->format('M, d Y');
        $dt = $start." - ".$end; 
        //dd($week);   
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $week)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::whereBetween('date', $week)->get();

        //dd($dt);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.visitors.pdf', compact('show', 'visitors', 'dt'));
        return $pdf->stream();
    }

    public function printmonth(Request $request)
    {
        
        $month = [Carbon::parse($request->month)->startOfMonth(), Carbon::parse($request->month)->endOfMonth()];
        $dt =  Carbon::parse($request->month)->format('F, Y'); 
        //dd($week);   
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $month)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::whereBetween('date', $month)->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.visitors.pdf', compact('show', 'visitors', 'dt'));
        return $pdf->stream();
    }


    public function searchtoday()
    {
        $date =  [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];
        $dt = Carbon::now()->format('M, d Y');
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->where('date', $date)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::whereBetween('date', $date)->get();

        //dd($visitors);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'date', 'dt'));
    }



    public function detail($id)
    {
        return TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->orderBy('created_at','DESC')->findOrFail($id);
    }
    
    public function search(Request $request)
    {
        $date = Carbon::now();
        $dt = Carbon::parse($request->date)->format('M, d Y');
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->where('date', '=', $request->date)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::where('date', '=', $request->date)->get();

        //dd($visitors);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
    }

    
    public function searchbyweek()
    {
        
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]; 
        $start = Carbon::now()->startOfWeek()->format('M, d Y');
        $end =  Carbon::now()->endOfWeek()->format('M, d Y');
        $dt = $start." - ".$end;
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $week)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::whereBetween('date', $week)->get();

        //dd($dt);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
    }

    public function week(Request $request)
    {
        
        $week = [Carbon::parse($request->week)->startOfWeek(), Carbon::parse($request->week)->endOfWeek()]; 
        $start = Carbon::parse($request->week)->startOfWeek()->format('M, d Y');
        $end =  Carbon::parse($request->week)->endOfWeek()->format('M, d Y');
        $dt = $start." - ".$end; 
        //dd($week);   
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $week)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::whereBetween('date', $week)->get();

        //dd($show);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
    }

    public function month(Request $request)
    {
        
        $month = [Carbon::parse($request->month)->startOfMonth(), Carbon::parse($request->month)->endOfMonth()];
        $dt =  Carbon::parse($request->month)->format('F, Y'); 
        //dd($week);   
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $month)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::whereBetween('date', $month)->get();

        //dd($show);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
    }


    public function searchbymonth()
    {
        
        $week = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];  
        $dt = Carbon::now()->format('F, Y');  
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $week)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::whereBetween('date', $week)->get();

        //dd($show);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
    }

    public function searchnotallowed()
    {
        
        $dt = "Not Allowed";
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->where('in', '=', 'Not allowed')->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::where('in', '=', 'Not allowed')->get();

        //dd($show);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
    }

    public function searchrole(Request $request)
    {
        
        $role = $request->role;
        $dt =  $request->role;
        $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->where('role', '=', $role)->orderBy('created_at','DESC')->paginate(1000);
        $show = TravelHistory::where('role', '=', $role)->get();

        //dd($show);
        return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
    }



    public function searchrange(Request $request)
    {
        $range = [new Carbon($request->date1), new Carbon($request->date2)];

        $start = Carbon::parse($request->date1)->format('M, d Y');
        $end =  Carbon::parse($request->date2)->format('M, d Y');
        $dt = $start." - ".$end; 
        
        if($request->date1 > $request->date2){
            return redirect()->route('visitors')->with('error', 'Start date cannot be greater than End date');
        }

        else{
            $visitors = TravelHistory::where('establishment_id','=',Auth::guard('establishment')->user()->id)->whereBetween('date', $range)->orderBy('created_at','DESC')->paginate(1000);
            $show = TravelHistory::whereBetween('date', $range)->get();
    
            //dd($visitors);
            return view('pages.establishment.visitors.index', compact('show', 'visitors', 'dt'));
        }
        
    }

}
       