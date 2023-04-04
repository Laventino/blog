<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\listTask;
use App\tasks;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $menu_name = "task";
        $lists = listTask::where("user_id",Auth::id())->orderBy('rank', 'asc')->get();
        return \View::make('task.index', compact('menu_name','lists'));
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
        $maxValue = tasks::where("list_id",$request->list_id)->orderBy('rank', 'desc')->value('rank'); 
        $lists = new tasks;
        $lists->list_id= $request->list_id;
        $lists->user_id= Auth::id();
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
        ]);
        if ($validator->fails()) {
            return false;
        }
        $maxValue = listTask::where("user_id",Auth::id())->orderBy('rank', 'desc')->value('rank'); 
        $lists = new listTask;
        $lists->user_id= Auth::id();
        $lists->title= $request->title;
        $lists->rank= $maxValue?$maxValue:0 + 1;
        $lists->created_at= Carbon::now()->toDateTimeString();
        $lists->save();
        return $lists;
    }

    public function changePosition(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'task' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return false;
        // }
        if(isset($request->list)){
            $i = 1;
            foreach ($request->list as $value) {

                $lists = listTask::where("user_id",Auth::id())->where("id",$value["id"])->first();
                $lists->rank = $i;
                $lists->save();
                $i += 1;
            }
        }
        if(isset($request->task)){
            $i = 1;
            foreach ($request->task as $value) {
                if(isset($value["tasks"])){
                    foreach ($value["tasks"] as $task) {
                        $query_task = tasks::where("user_id",Auth::id())->where("id",$task["id"])->first();
                        $query_task->rank = $i;
                        $query_task->list_id = $value["list_id"];
                        $query_task->save();
                        $i += 1;
                    }
                }
                
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
