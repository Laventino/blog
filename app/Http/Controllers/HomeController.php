<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Video;
use App\Image;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu_name = "home";
        $videoCount = Video::get()->count();
        $imageCount = Image::get()->count();
        $summary = [
            'total_video' => $videoCount,
            'total_image' => $imageCount,
        ];
        return \View::make('home', compact('menu_name', 'summary'));
    }
}
