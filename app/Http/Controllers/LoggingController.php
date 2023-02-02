<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class LoggingController extends Controller
{
    public function index()
    {
        $user = User::get();
        return view('logging.login',compact('user'));
    }
 
}
