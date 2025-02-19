<?php

namespace App\Http\Controllers;
use App\Video;
use App\Workspace;
use App\ListTasks;
use App\Tasks;
use App\WorkspaceParticipant;
use App\MarkCategory;
use App\Mark;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu_name = "workspace";
        $workspace = Workspace::where("user_id",Auth::id())->where("archive",0)->get();
        $workspace_participant = WorkspaceParticipant::where("user_id",Auth::id())->where("archive",0)->get();

        return \View::make('workspace.index', compact('menu_name','workspace','workspace_participant'));
    }


    public function createNewWorkspace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return false;
        }
        $workspace = new Workspace;
        $workspace->user_id= Auth::id();
        $workspace->title= $request->title;
        $workspace->description= $request->description;
        $workspace->created_at= Carbon::now()->toDateTimeString();
        $workspace->save();
        // $Workspace_participant = new WorkspaceParticipant;
        // $Workspace_participant->user_id= Auth::id();
        // $Workspace_participant->workspace_id = $workspace->id;
        // $Workspace_participant->created_at= Carbon::now()->toDateTimeString();
        // $Workspace_participant->save();

        return $workspace;
    }

    public function archiveWorkspace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workspace_id' => 'required',
        ]);
        if ($validator->fails()) {
            return false;
        }
        $workspace = Workspace::where("user_id",Auth::id())->where("id",$request->workspace_id)->first();
        if($workspace == null){
            return false;
        }
        $workspace->archive = 1;
        $workspace->save();
        return $workspace;
    }

    public function editWorkspace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workspace_id' => 'required',
        ]);
        if ($validator->fails()) {
            return false;
        }
        $workspace = Workspace::where("user_id",Auth::id())->where("id",$request->workspace_id)->first();
        if($workspace == null){
            return false;
        }
        $workspace->title = $request->title;
        $workspace->description = $request->description;
        $workspace->save();
        return $workspace;
    }

    public function statusUpdate(Request $request)
    {
        $id = $request->id;

        $categoryType = MarkCategory::where('name', $request->status)->first();
        $mark = Mark::where([
            'item_id' => (int) $id,
            'type' => $categoryType->id
            ])->first();
        if ($mark) {
            $mark->update([
                'status' => !$mark->status
            ]);
        } else {
            Mark::create([
                "category"      => "video",
                "item_id"       => $id,
                "type"          => $categoryType->id,
                'status'        => 1
            ]);
        }
        return $mark ? $mark->status : 1;
    }

    public function move(Request $request)
    {
        $id = $request->id;

        $video = Video::find($id);
        $video->path;
        $path = storage_path() . "/app/public" . $video->path;
        $filename = basename($path);
        $newPath = "/videos/video/old/" . $filename;
        $destinationPath = storage_path() . "/app/public" . $newPath;
        copy($path, $destinationPath);
        if (file_exists($destinationPath)) {
            $video->update(['path' => $newPath]);
            unlink($path);
            return 'move';
        }

        return 'false';
    }

    public function getWorkspace($id)
    {
        $menu_name = "workspace";
        $workspace = Workspace::where("user_id",Auth::id())->where("id",$id)->first();
        $participants = WorkspaceParticipant::where("user_id",Auth::id())->where("workspace_id",$id)->where("archive",0)->first();
        if($workspace == null && $participants == null){
            return false;
        }
        $lists = ListTasks::where("workspace_id",$id)->where("archive",0)->orderBy('rank', 'asc')->get();
        $participants = WorkspaceParticipant::where("workspace_id",$id)->where("archive",0)->get();
        $workspace = Workspace::where("id",$id)->first();
        return \View::make('task.index', compact('workspace','menu_name','lists','participants'));
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
        //
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
