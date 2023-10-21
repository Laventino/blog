<?php

namespace App\Http\Controllers;

use App\Models\GroupMedia;
use Illuminate\Http\Request;
use App\Jobs\ResetVideo;

class SettingController extends Controller
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
        $menu_name = "setting";
        $groupMedias = GroupMedia::where("type","video")->get();
        return \View::make('setting.index', compact('menu_name', 'groupMedias'));
    }

    public function resetMedias(Request $request)
    {
        return response()->json([], 200);

        // $mediaIds = $request->get('media_ids');
        // $groupMedias = GroupMedia::whereIn('id', $mediaIds)->get();
        // foreach ($groupMedias as $key => $value) {
        //     dispatch(new ResetVideo($value));
        // }

    }
}
