<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manga;
use App\MangaImage;
class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Manga::select('manga.*', \DB::raw('COUNT(manga_images.id) as image_count'))->join('manga_images','manga.id','manga_images.manga_id')->groupBy('manga.id')->whereNotNull('manga_images.id')->paginate(20);
        return \View::make('manga.index', compact('datas'));
    }

    public function trash(Request $request) 
    {
        $storagePath = storage_path() .'\app\public\videos\PT\manga';
        $manga = Manga::find($request->get('id'));
        // rename($source, $destination)
        // return $request->get('id');
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
        $data = MangaImage::where('manga_id',$id)->orderByRaw("CASE WHEN name REGEXP '^[a-zA-Z]' THEN 1 ELSE 0 END ASC, CAST(name AS UNSIGNED) ASC")->get();
        return \View::make('manga.show', compact(['data', 'id']));
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