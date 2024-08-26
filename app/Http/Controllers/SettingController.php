<?php

namespace App\Http\Controllers;

use App\Jobs\MergeVideo;
use App\Jobs\ResetManga;
use App\Jobs\ConvertVideo;
use App\Models\GroupMedia;
use Illuminate\Http\Request;
use App\Jobs\ResetVideo;
use Illuminate\Support\Facades\Artisan;

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
        $mediaIds = $request->get('media_ids');
        $groupMedias = GroupMedia::whereIn('id', $mediaIds)->get();
        foreach ($groupMedias as $key => $value) {
            dispatch(new ResetVideo($value));
        }

        return response()->json([], 200);
    }
    
    public function resetManga(Request $request)
    {
        dispatch(new ResetManga());

        return response()->json([], 200);
    }
    
    public function convertVideo(Request $request)
    {
        dispatch(new ConvertVideo());

        return response()->json([], 200);
    }

    public function mergeVideo(Request $request)
    {
        dispatch(new MergeVideo());

        return response()->json([], 200);
    }
}
