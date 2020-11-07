<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
    	if(Auth::check()){
    		return view('bqs.dashboard');
	     }
         return redirect('/bqs_template/login_bqs')->withSuccess('Oppes! You have entered invalid credentials');
    }
    
}
