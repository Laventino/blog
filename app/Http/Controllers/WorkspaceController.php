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
        $workspace = Workspace::where("user_id",Auth::id())->get();
        $workspace_participant = WorkspaceParticipant::where("user_id",Auth::id())->get();
       
        // $x = DB::table('list_tasks')
        // ->join('tasks', 'tasks.list_id', '=', 'list_tasks.id')->select('list_tasks.title as t1','tasks.title as t2','list_tasks.*')
        // ->get();
        // dd($x);

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
        return $workspace;
    }

    public function getWorkspace($id)
    {
        $menu_name = "workspace";
        $workspace = Workspace::where("user_id",Auth::id())->where("id",$id)->first();
        if($workspace == null){
            return false;
        }
        $lists = ListTasks::where("workspace_id",$id)->where("archive",0)->orderBy('rank', 'asc')->get();
        return \View::make('task.index', compact('menu_name','lists'));
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
