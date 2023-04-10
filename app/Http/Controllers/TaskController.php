<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workspace;
use App\ListTasks;
use App\Tasks;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        // $menu_name = "task";
        // $lists = ListTasks::where("user_id",Auth::id())->orderBy('rank', 'asc')->get();
       
        // $x = DB::table('list_tasks')
        // ->join('tasks', 'tasks.list_id', '=', 'list_tasks.id')->select('list_tasks.title as t1','tasks.title as t2','list_tasks.*')
        // ->get();
        // dd($x);

        // return \View::make('task.index', compact('menu_name','lists'));
    }

    
    public function addNewCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'list_id' => 'required',
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return false;
        }
        $maxValue = Tasks::where("list_id",$request->list_id)->orderBy('rank', 'desc')->value('rank'); 
        $lists = new Tasks;
        $lists->list_id= $request->list_id;
        $lists->title= $request->title;
        $lists->rank= ($maxValue?$maxValue:0) + 1;
        $lists->created_at= Carbon::now()->toDateTimeString();
        $lists->save();
        return $lists;
    }
    public function addNewList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'workspace_id' => 'required',
        ]);
        if ($validator->fails()) {
            return false;
        }
        $workspace = Workspace::where("user_id",Auth::id())->where("id",$request->workspace_id)->first();
        if($workspace == null){
            return false;
        }
        $maxValue = ListTasks::where("workspace_id",$request->workspace_id)->orderBy('rank', 'desc')->value('rank'); 
        $lists = new ListTasks;
        $lists->title= $request->title;
        $lists->workspace_id = $request->workspace_id;
        $lists->rank= ($maxValue?$maxValue:0) + 1;
        $lists->created_at= Carbon::now()->toDateTimeString();
        $lists->save();
        return $lists;
    }

    public function changePosition(Request $request)
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
        if(isset($request->list)){
            $i = 1;
            foreach ($request->list as $value) {
                $lists = ListTasks::where("workspace_id",$request->workspace_id)->where("id",$value["id"])->first();
                $lists->rank = $i;
                $lists->save();
                $i += 1;
            }
        }
        if(isset($request->task)){
            $i = 1;
            foreach ($request->task as $value) {
                if(isset($value["tasks"])){
                    $lists = ListTasks::where("workspace_id",$request->workspace_id)->where("id",$value["list_id"])->first();
                    if($workspace != null){
                        foreach ($value["tasks"] as $task) {
                            $query_task = Tasks::where("id",$task["id"])->first();
                            $check = ListTasks::where("workspace_id",$request->workspace_id)->where("id",$query_task->list_id)->first();
                            if($check  != null){
                                $query_task->rank = $i;
                                $query_task->list_id = $value["list_id"];
                                $query_task->save();
                                $i += 1;
                            }
                        }
                    }
                }
                
            }
        }
        return true;
    }
    
    public function archive(Request $request)
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
        if(isset($request->list_id)){
            $lists = ListTasks::where("workspace_id",$request->workspace_id)->where("id",$request->list_id)->first();
            $lists->archive = 1;
            $lists->save();
        }
        if(isset($request->task)){
            $query_task = Tasks::where("id",$request->task)->first();
            $check = ListTasks::where("workspace_id",$request->workspace_id)->where("id",$query_task->list_id)->first();
            if($check  != null){
                $query_task->archive = 1;
                $query_task->save();
            }
        }
        return true;
    }

    public function changeTitle(Request $request)
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
        if(isset($request->list_title) && isset($request->list_id)){
            $lists = ListTasks::where("workspace_id",$request->workspace_id)->where("id",$request->list_id)->first();
            $lists->title = $request->list_title;
            $lists->save();
        }
        if(isset($request->task_title) && isset($request->task_id)){
            $query_task = Tasks::where("id",$request->task)->first();
            $check = ListTasks::where("workspace_id",$request->workspace_id)->where("id",$query_task->list_id)->first();
            if($check  != null){
                $query_task->title = $request->task_title;
                $query_task->save();
            }
        }
        return true;
    }
    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
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
