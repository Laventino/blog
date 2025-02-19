<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class LoggingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = User::get();
        return view('logging.login',compact('user'));
    }
 
}
