<?php

namespace App\Http\Controllers;
use App\Workspace;
use App\ListTasks;
use App\Tasks;
use App\Image;
use App\Models\GroupMedia;
use App\WorkspaceParticipant;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $datas = GroupMedia::with('image')->where('type','image')->get();
        return \View::make('image.index', compact('datas'));
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
        // $prev = Video::where("extension","mp4")->where('id','<',$id)->orderBy('id','DESC')->first();
        // $next = Video::where("extension","mp4")->where('id','>',$id)->first();
        // $datas = Video::where("extension","mp4")->where('id','>',$id)->paginate(15);
        // $data = Video::find($id);
        // return \View::make('video.show', compact(['data','prev','next','datas']));
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
