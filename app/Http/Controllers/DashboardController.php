<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class DashboardController extends Controller
{
    public function index()
    {
        $user = User::get();
        return view('dashboard.index',compact('user'));
    }
    public function show()
    {
        $user = User::get();
        return view('dashboard.header',compact('user'));
    }
}
