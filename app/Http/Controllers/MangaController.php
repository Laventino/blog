<?php

namespace App\Http\Controllers;

use App\Manga;
use App\MangaImage;
use App\Models\GroupMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MangaController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->type;

        $datas = Manga::where('manga.status', 1)
            ->when($type == 'read', function($query) {
                $query->where('read', true);
            })
            ->when($type == 'later', function($query) {
                $query->where('group_id', 1);
            })
            ->when($type == 'interest', function($query) {
                $query->where('group_id', 2);
            })
            ->orderBy('read', 'asc')
            ->orderBy('group_id', 'asc')
            ->paginate(20);

        $groupMedias = GroupMedia::where("type","manga")
            ->get();
        return \View::make('manga.index', compact('datas', 'groupMedias'));
    }

    public function trash(Request $request) 
    {
        $manga = Manga::find($request->get('id'));
        
        $sourcePath = 'public/videos/PT/manga' . '/' . $manga->genre . '/' . $manga->name;
        $destinationPath = 'public/videos/PT/manga_trashed' . '/' . $manga->genre . '/' . $manga->name;
        if (Storage::exists($sourcePath)) {
            Storage::move($sourcePath, $destinationPath);
            $manga->update([
                'status' => 2
            ]);
        } else {
            logger('Manga folder can be found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manga =Manga::find($id);
        $data = MangaImage::where('manga_id',$id)->orderByRaw("CASE WHEN name REGEXP '^[a-zA-Z]' THEN 1 ELSE 0 END ASC, CAST(name AS UNSIGNED) ASC")->get();
        $path = $data->pluck('path')->toArray();
        return \View::make('manga.show', compact(['data', 'id', 'path', 'manga']));
    }
    public function read(Request $request)
    {
        $manga = Manga::find($request->id);
        $file = storage_path("$manga->path/info.json");
        
        if (file_exists($file)) {
            $jsonString = file_get_contents($file);
            $data = json_decode($jsonString, true);
            if ($data === null) {
                \Log::info('item',['Error decoding JSON.']);
            } else {
                $data['viewed'] = !$manga->read;
                $jsonData = json_encode($data);
                file_put_contents($file, $jsonData);
            }
        } else {
            $data = ['viewed' => !$manga->read];
            $jsonData = json_encode($data);
            file_put_contents($file, $jsonData);
        } 
        $manga->update(['read' => !$manga->read]);
        return !$manga->read;
    }

    public function group(Request $request)
    {
        $id = $request->id;
        $groupId = $request->group;
        $manga = Manga::find($id);
        $file = storage_path("$manga->path/info.json");
        
        if (file_exists($file)) {
            $jsonString = file_get_contents($file);
            $data = json_decode($jsonString, true);
            if ($data === null) {
                \Log::info('item',['Error decoding JSON.']);
            } else {
                $data['group_id'] = $groupId;
                $jsonData = json_encode($data);
                file_put_contents($file, $jsonData);
            }
        } else {
            $data = ['group_id' => $groupId];
            $jsonData = json_encode($data);
            file_put_contents($file, $jsonData);
        } 
        $manga->update(['group_id' => $request->group]);
        return $request->group;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}