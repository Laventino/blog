<?php

namespace App\Http\Controllers;

use App\Jobs\EHentaiDownloadImage;
use App\DownloadImage;
use Illuminate\Http\Request;

class DownloadImageController extends Controller
{
    public function index()
    {
        $menu_name = "download-image";
        $datas = '';
        return \View::make('donwload-image.index', compact('menu_name','datas'));
    }

    public function downloadImage(Request $request)
    {
        try {
            $start = $request->get('start');
            $skip = isset($start) ? $start : null;
            $url = $request->get('url');
            $downloadImage = DownloadImage::create([
                'url' => $url,
                'status' => 0,
                'total' => null,
                'completed' => 0,
            ]);
            dispatch(new EHentaiDownloadImage($url, $skip,$downloadImage->id));
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }
    
}
