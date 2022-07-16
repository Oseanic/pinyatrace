<?php

namespace App\Http\Controllers\Establishment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Attendance;
use Auth;
use PDF;

class AttendanceController extends Controller
{
    public function index()
    {
        $date = "Latest to Oldest"; 
        $dt = "Latest to Oldest";
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]; 
       
        $attendances = Attendance::orderBy('updated_at','DESC')->paginate(15);

        return view('pages.establishment.attendance.index', compact('attendances', 'week', 'date', 'dt'));
    }

    public function kick($id)
    {   
        $attendance = Attendance::find($id);
        
        $attendance->update([
            'date' =>  Carbon::now()->format('Y-m-d'),
            'out'   => "Scanned out by Admin: ".Carbon::now()->isoFormat('hh:mm a'),
        ]);

        return redirect()->route('attendance')->with('error', 'Student has been logged out of the establishment');
    }

    public function detail($id)
    {
        return Attendance::findOrFail($id);
    }

    public function searchtoday()
    {
        $date =  [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];
        $dt = Carbon::now()->format('M, d Y');
        $attendances = Attendance::where('date', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::whereBetween('date', $date)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'date', 'dt'));
    }

    public function searchtodaymonth()
    {
        $date =  [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
        $dt = Carbon::now()->format('M, Y');
        $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::whereBetween('date', $date)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'date', 'dt'));
    }

    public function searchtodayweek()
    {
        $date =  [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $start = Carbon::now()->startOfWeek()->format('M, d Y');
        $end =  Carbon::now()->endOfWeek()->format('M, d Y');
        $dt = $start." - ".$end;
        $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::whereBetween('date', $date)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'date', 'dt'));
    }

    public function searchday(Request $request)
    {
        $date = Carbon::parse($request->date);
        $dt = Carbon::parse($request->date)->format('M, d Y');
        $attendances = Attendance::where('date', '=', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::where('date', '=', $date)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'date', 'dt'));
    }

    public function searchweek(Request $request)
    {
        $date = [Carbon::parse($request->week)->startOfWeek(), Carbon::parse($request->week)->endOfWeek()]; 
        $start = Carbon::parse($request->week)->startOfWeek()->format('M, d Y');
        $end =  Carbon::parse($request->week)->endOfWeek()->format('M, d Y');
        $dt = $start." - ".$end; 
        $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::whereBetween('date', $date)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'date', 'dt'));
    }

    public function searchmonth(Request $request)
    {
        $date = [Carbon::parse($request->month)->startOfMonth(), Carbon::parse($request->month)->endOfMonth()];
        $dt = Carbon::parse($request->month)->format('F, Y');
        $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::whereBetween('date', $date)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'date', 'dt'));
    }

    public function searchrange(Request $request)
    {
        $date = [new Carbon($request->date1), new Carbon($request->date2)];

        $start = Carbon::parse($request->date1)->format('M, d Y');
        $end =  Carbon::parse($request->date2)->format('M, d Y');
        $dt = $start." - ".$end; 
        
        if($request->date1 > $request->date2){
            return redirect()->route('attendance')->with('error', 'Start date cannot be greater than End date');
        }

        else{
            $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
            $show = Attendance::whereBetween('date', $date)->get();

            return view('pages.establishment.attendance.index', compact('show', 'attendances', 'date', 'dt'));
        }
    }

    public function searchrole(Request $request)
    {
        $role = $request->role;
        $dt =  $request->role;
        $attendances = Attendance::where('role', '=', $role)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::where('role', '=', $role)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'role', 'dt'));
    }

    public function searchnotallowed()
    {
        $dt = "Not Allowed";
        $attendances = Attendance::where('in', '=', $dt)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::where('in', '=', $dt)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'dt'));
    }

    public function searchsection(Request $request)
    {
        $dt = $request->course." ".$request->section;
        $attendances = Attendance::where('section', '=', $dt)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::where('section', '=', $dt)->get();

        return view('pages.establishment.attendance.index', compact('show', 'attendances', 'dt'));
    }


    public function printday(Request $request)
    {
        $date = Carbon::parse($request->date);
        $dt = Carbon::parse($request->date)->format('M, d Y');
        $attendances = Attendance::where('date', '=', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::where('date', '=', $date)->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.attendance.pdf', compact('show', 'attendances', 'dt'));
        return $pdf->stream();
    }

    public function printweek(Request $request)
    {
        $date = [Carbon::parse($request->week)->startOfWeek(), Carbon::parse($request->week)->endOfWeek()]; 
        $start = Carbon::parse($request->week)->startOfWeek()->format('M, d Y');
        $end =  Carbon::parse($request->week)->endOfWeek()->format('M, d Y');
        $dt = $start." - ".$end; 
        $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::whereBetween('date', $date)->get();
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.attendance.pdf', compact('show', 'attendances', 'dt'));
        return $pdf->stream();
    }

    public function printmonth(Request $request)
    {   
        $date = [Carbon::parse($request->month)->startOfMonth(), Carbon::parse($request->month)->endOfMonth()];
        $dt = Carbon::parse($request->month)->format('F, Y');
        $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::whereBetween('date', $date)->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.attendance.pdf', compact('show', 'attendances', 'dt'));
        return $pdf->stream();
    }

    public function printrange(Request $request)
    {
        $date = [new Carbon($request->date1), new Carbon($request->date2)];

        $start = Carbon::parse($request->date1)->format('M, d Y');
        $end =  Carbon::parse($request->date2)->format('M, d Y');
        $dt = $start." - ".$end; 
        
        if($request->date1 > $request->date2){
            return redirect()->route('attendance')->with('error', 'Start date cannot be greater than End date');
        }

        else{
            $attendances = Attendance::whereBetween('date', $date)->orderBy('date','DESC')->paginate(1000);
            $show = Attendance::whereBetween('date', $date)->get();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView('pages.establishment.attendance.pdf', compact('show', 'attendances', 'dt'));
            return $pdf->stream();
        }
    }

    public function printall()
    {   
        $date = "Latest to Oldest"; 
        $dt = "Latest to Oldest";
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]; 
       
        $attendances = Attendance::orderBy('updated_at','DESC')->paginate(15);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.attendance.pdf', compact('attendances', 'dt'));
        return $pdf->stream();
    }

    public function printnotallowed()
    {
        $dt = "Not Allowed";
        $attendances = Attendance::where('in', '=', $dt)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::where('in', '=', $dt)->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.attendance.pdf', compact('show', 'attendances', 'dt'));
        return $pdf->stream();
    }

    public function printsection(Request $request)
    {
        $dt = $request->course." ".$request->section;
        $attendances = Attendance::where('section', '=', $dt)->orderBy('date','DESC')->paginate(1000);
        $show = Attendance::where('section', '=', $dt)->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.establishment.attendance.pdf', compact('show', 'attendances', 'dt'));
        return $pdf->stream();        
    }

}
