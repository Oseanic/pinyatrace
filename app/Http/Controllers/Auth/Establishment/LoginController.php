<?php

namespace App\Http\Controllers\Auth\Establishment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:establishment', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.establishment.log-in');
    }

    public function login(Request $request)
    {
        //* Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        //* Attempt to log the user in
        if(Auth::guard('establishment')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            //* If successful, then redirect to their intended location
            return redirect()->intended(route('establishment'));
        }
        //* If unsuccessful, redirect back to login
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('establishment')->logout();
        return redirect('/establishment');
    }
}
