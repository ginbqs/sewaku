<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
    public function postLogin(Request $request)
    {
    	$input = $request->all();
        request()->validate([
        'username' => 'required',
        'password' => 'required',
        ]);
 		$fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_hp';
        if(auth()->attempt(array(''.$fieldType => $input['username'], 'password' => $input['password'])))
        {
            return redirect()->intended('/bqs_template/dashboard');
        }

         return redirect('/bqs_template/login_bqs')->withSuccess('Oppes! You have entered invalid credentials');
    }
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('bqs_template/login_bqs');
    }
}
