<?php

namespace App\Http\Controllers;

use App\Jobs\EHentaiDownloadImage;
use App\Jobs\ImHentaiDownloadImage;
use App\Jobs\NHentaiDownloadImage;
use App\DownloadImage;
use Illuminate\Http\Request;

class DownloadImageController extends Controller
{
    public function index()
    {
        $menu_name = "download-image";
        $data = DownloadImage::whereIn('status', [0,1,2,4])->get();

        return \View::make('donwload-image.index', compact('menu_name','data'));
    }

    public function downloadImage(Request $request)
    {
        try {
            $start = $request->get('start');
            $skip = isset($start) ? $start : null;
            $url = $request->get('url');

            $parsedUrl = parse_url($url);
            $path = rtrim($parsedUrl['path'], '/');
            $baseUrl = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $path;
            $check = DownloadImage::where([
                    'url' => $baseUrl,
                ])
                ->whereIn('status', [0, 1, 2, 3, 4])
                ->first();
            if ($check) {
                return $check->status_text;
            }

            $downloadImage = DownloadImage::create([
                'url' => $baseUrl,
                'status' => 0,
                'total' => null,
                'completed' => 0,
            ]);
            if (strpos($url, "e-hentai") !== false) {
                $job = dispatch(new EHentaiDownloadImage($url, $skip,$downloadImage->id));
            } elseif (strpos($url, "nhentai") !== false) {
                $job = dispatch(new NHentaiDownloadImage($url, $skip,$downloadImage->id));
            } else {
                \Log::info('item',['Download can not found source type']);
            }
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }

    public function retryDownload(Request $request)
    {
        try {
            $id = $request->get('id');
            $downloadImage = DownloadImage::find($id);
            if ($downloadImage) {
                if (strpos($downloadImage->url, "e-hentai") !== false) {
                    dispatch(new EHentaiDownloadImage($downloadImage->url, $downloadImage->completed, $downloadImage->id));
                } elseif (strpos($downloadImage->url, "nhentai") !== false) {
                    dispatch(new NHentaiDownloadImage($downloadImage->url, $downloadImage->completed, $downloadImage->id));
                } elseif (strpos($downloadImage->url, "imhentai") !== false) {
                    dispatch(new ImHentaiDownloadImage($downloadImage->url, $downloadImage->completed, $downloadImage->id));
                } else {
                    \Log::info('item',['Retry can not found source type']);
                }
            }
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }

    public function deleteDownload(Request $request)
    {
        try {
            $id = $request->get('id');
            $downloadImage = DownloadImage::find($id);
            if ($downloadImage) {
                $downloadImage->delete();
            }
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }
}
