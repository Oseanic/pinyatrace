<?php

namespace App\Http\Controllers\ContactTracer;

use App\Models\Barangay;
use App\Models\CovidCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Cases extends Controller
{
    public function index()
    {
        $cases = CovidCase::paginate(12);
        $barangays = Barangay::all();
        return view('pages.contact_tracer.cases.index', compact(['cases', 'barangays']));
    }

    public function store(Request $request)
    {
        CovidCase::create($request->all());
        return redirect()->route('cases')->with('success', 'Data saved successfully!');

    }

    public function update(Request $request, $id)
    {

        CovidCase::where('id','=',$id)->update([
            'patient_id' => $request->patient_id,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'number' => $request->number,
            'status' => $request->status
        ]);
        return redirect()->route('cases')->with('success', 'Data updated successfully!');

    }
}
