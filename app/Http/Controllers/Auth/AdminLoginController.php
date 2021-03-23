<?php
namespace App\Http\Controllers\Auth;
// namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        //Validate the form data
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        $credentials = $request->only('email', 'password');
        $remember = $request->remember;

        //Attempt to log the user in
        if(Auth::guard('admin')->attempt($credentials, $remember))
        {
            //if Successfully , log in and redirect to intended location(Default is dashboard)
            return redirect()->intended(route('admin.dashboard'));
        }

        //if Unsuccessfull, redirect back to login page with form data
        return redirect()->back()->withInput($request->only('email','remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
