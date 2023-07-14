<?php

namespace App\Http\Controllers;
use App\Workspace;
use App\ListTasks;
use App\Tasks;
use App\WorkspaceParticipant;
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
