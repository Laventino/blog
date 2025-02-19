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

    public function moveToTrash(Request $request)
    {
        $path = storage_path() . "/app/public" . str_replace('storage', '', $request->src);
        $filename = basename($path);
        $newPath = "/videos/video/trash/" . $filename;
        $destinationPath = storage_path() . "/app/public" . $newPath;
        copy($path, $destinationPath);
        if (file_exists($destinationPath)) {
            unlink($path);
        }

        return true;
    }

    public function folder(Request $request)
    {
        $requestPath = $request->path;
        $previousPath = "";
        $removePath = strrpos($requestPath, '/');
        if ($removePath !== false) {
            $removePath = substr($requestPath, 0, $removePath);
            $previousPath = $removePath != "/videos/video" ? $removePath : "";
        }

        $path = storage_path() . ($requestPath ? ("/app/public" . $requestPath) : "/app/public/videos/video");
        $arrPath = $this->looping($path);
 
        array_multisort(array_column($arrPath, 'ext'), SORT_ASC, $arrPath);

        return \View::make('video.indexFolder', compact('arrPath', 'previousPath'));
    }

    
    public function looping($path){
        $arr =  array();
        $arr_in_file = array();

        foreach(scandir($path) as $file) {
            if($file == "." || $file == ".." || $file == "web" || $file == 'PT'){
                continue;
            }
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            array_push($arr, [
                'path' => substr($path,strlen(storage_path().'/app/public')).'/'.$file,
                'img_path' => 'storage/thumbnail' . substr($path,strlen(storage_path().'/app/public')).'/'.str_replace('.mp4','.jpg', $file),
                'name' => $file,
                'ext' => $ext
            ]);
        }
        $arr = array_merge($arr, $arr_in_file);
        return $arr;
    }
}
