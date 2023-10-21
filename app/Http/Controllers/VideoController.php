<?php

namespace App\Http\Controllers;
use App\Workspace;
use App\ListTasks;
use App\Tasks;
use App\Video;
use App\WorkspaceParticipant;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\GroupMedia;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $datas = Video::where("extension","mp4")
            ->orderBy('id','desc')
            ->paginate(30);

        $groupMedias = GroupMedia::where("type","video")
            ->get();
        return \View::make('video.index', compact('datas','groupMedias'));
    }

    public function getByMenu($menu)
    {

        $groupMedias = GroupMedia::where("name", $menu)
            ->first();
        $datas = Video::where("extension","mp4")
            ->when($menu , function($query) use ($groupMedias) {
                $query->where('path', 'like', $groupMedias->path . '%');
            })
            ->orderBy('id','desc')
            ->paginate(30);

        $groupMedias = GroupMedia::where("type","video")
            ->get();
        return \View::make('video.index', compact('datas','groupMedias'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
    }


    public function show($id)
    {
        $prev = Video::where("extension","mp4")->where('id','<',$id)->orderBy('id','DESC')->first();
        $next = Video::where("extension","mp4")->where('id','>',$id)->first();
        $datas = Video::where("extension","mp4")->where('id','<',$id)->orderBy('id', 'desc')->paginate(15);
        $data = Video::find($id);
        return \View::make('video.show', compact(['data','prev','next','datas']));
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
