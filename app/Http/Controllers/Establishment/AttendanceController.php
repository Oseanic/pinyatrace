<?php

namespace App\Http\Controllers\Establishment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $date = "Latest to Oldest"; 
        $dt = "Latest to Oldest";
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]; 
       
        $attendances = Attendance::orderBy('created_at','DESC')->paginate(15);

        return view('pages.establishment.attendance.index', compact('attendances', 'week', 'date', 'dt'));
    }

    public function kick($id)
    {
        Attendance::find($id)->update([
            'date' =>  Carbon::now()->format('Y-m-d'),
            'out'   => Carbon::now()->isoFormat('hh:mm a'),
            'role' => Auth::user()->profile->role,
            'id_number' => Auth::user()->profile->id_number,
            'section' => Auth::user()->profile->getfullsection(),
        ]);

        return view('pages.establishment.attendance.index', compact('attendances', 'week', 'date', 'dt'));
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

}
