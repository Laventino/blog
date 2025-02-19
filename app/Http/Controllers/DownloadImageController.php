<?php

namespace App\Http\Controllers;

use App\Jobs\EHentaiDownloadImage;
use App\Jobs\ImHentaiDownloadImage;
use App\Jobs\NHentaiDownloadImage;
use App\DownloadImage;
use DB;
use Http;
use Illuminate\Http\Request;

class DownloadImageController extends Controller
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
            $detail = $this->getDetailFromSource($baseUrl);
            $downloadImage = DownloadImage::create([
                'url' => $baseUrl,
                'image' => $detail->image,
                'title' => $detail->title,
                'status' => 0,
                'total' => null,
                'completed' => 0,
            ]);
            if (strpos($url, "e-hentai") !== false) {
                $job = dispatch(new EHentaiDownloadImage($url, $skip,$downloadImage->id));
            } elseif (strpos($url, "nhentai") !== false) {
                $job = dispatch(new NHentaiDownloadImage($url, $skip,$downloadImage->id));
            } elseif (strpos($url, "imhentai") !== false) {
                $job = dispatch(new ImHentaiDownloadImage($url, $skip,$downloadImage->id));
            } else {
                \Log::info('item',['Download can not found source type']);
            }
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }

    protected function getDetailFromSource($url)
    {
        $parsedUrl = parse_url($url);
        $path = rtrim($parsedUrl['path'], '/');
        $baseUrl = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $path;
        
        if (strpos($url, "e-hentai") !== false) {
            $htmlListPage = Http::withOptions(['verify' => false])->get($baseUrl . '/?nw=always');

            $matchPreviewImageSrc = null;
            preg_match('/background:\s*transparent\s*url\((.*?)\)/', $htmlListPage, $matchPreviewImages);
            if (isset($matchPreviewImages[1])) {
                $matchPreviewImageSrc = $matchPreviewImages[1];
            }
            preg_match('/<h1\s+id="gn">(.*?)<\/h1>/', $htmlListPage, $matchesTile);
            $titleRaw = isset($matchesTile[1]) ? $matchesTile[1] : '';
            $title = str_replace(array(":", " |", "|", "?", ",", "."), "", urldecode(html_entity_decode($titleRaw)));
            $title = str_replace("/", "%", urldecode(html_entity_decode($title)));
            $title = str_replace(array('"', "#"), "-", urldecode(html_entity_decode($title)));
            $title = htmlspecialchars_decode(preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $title), ENT_QUOTES);
            return (object) [
                'title' => $title,
                'image' => $matchPreviewImageSrc
            ];
        } elseif (strpos($url, "nhentai") !== false) {
            $htmlListPage = Http::withOptions(['verify' => false])->get($baseUrl);
            $matchPreviewImageSrc = null;
            preg_match('/<div id="cover">.*?<img.*?data-src="([^"]+)".*?>/s', $htmlListPage, $matchPreviewImages);
            if (isset($matchPreviewImages[1])) {
                $matchPreviewImageSrc = $matchPreviewImages[1];
            }
            preg_match('/<span\s+class="pretty">(.*?)<\/span>/', $htmlListPage, $matchesTile);
            $titleRaw = isset($matchesTile[1]) ? $matchesTile[1] : '';
            // filter symbol can not use on folder
            $title = str_replace(array(":", " |", "|", "?", ",", "."), "", urldecode(html_entity_decode($titleRaw)));
            // Manually decode the HTML entity
            $title = htmlspecialchars_decode(preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $title), ENT_QUOTES);
            $title = str_replace("/", "--", urldecode(html_entity_decode($title)));
    
            return (object) [
                'title' => $title,
                'image' => $matchPreviewImageSrc
            ];
        } elseif (strpos($url, "imhentai") !== false) {
            $htmlListPage = Http::withOptions(['verify' => false])->get($baseUrl);
            
            $matchPreviewImageSrc = null;
            preg_match('/<div class="col-md-4 col left_cover">.*?<img.*?data-src="([^"]+)".*?>/s', $htmlListPage, $matchPreviewImages);
            if (isset($matchPreviewImages[1])) {
                $matchPreviewImageSrc = $matchPreviewImages[1];
            }
            preg_match('/<div class="col-md-7 col-sm-7 col-lg-8 right_details">\s*<h1>(.*?)<\/h1>/s', $htmlListPage, $matchesTitle);
            $titleRaw = isset($matchesTitle[1]) ? $matchesTitle[1] : '';
            $title = str_replace(array(":", " |", "|", "?", ",", "."), "", urldecode(html_entity_decode($titleRaw)));
            // Manually decode the HTML entity
            $title = htmlspecialchars_decode(preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $title), ENT_QUOTES);
            $title = str_replace("/", "%", urldecode(html_entity_decode($title)));
    
            return (object) [
                'title' => $title,
                'image' => $matchPreviewImageSrc
            ];
        } else {
            \Log::info('item',['Download can not found source type']);
        }
    }

    public function retryDownload(Request $request)
    {
        try {
            $id = $request->get('id');
            $downloadImage = DownloadImage::find($id);
            if ($downloadImage) {
                if (strpos($downloadImage->url, "e-hentai") !== false) {
                    dispatch(new EHentaiDownloadImage($downloadImage->url, null, $downloadImage->id));
                } elseif (strpos($downloadImage->url, "nhentai") !== false) {
                    dispatch(new NHentaiDownloadImage($downloadImage->url, null, $downloadImage->id));
                } elseif (strpos($downloadImage->url, "imhentai") !== false) {
                    dispatch(new ImHentaiDownloadImage($downloadImage->url, null, $downloadImage->id));
                } else {
                    \Log::info('item',['Retry can not found source type']);
                }
            }
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }

    public function fillDownload(Request $request)
    {
        try {
            $id = $request->get('id');
            $downloadImage = DownloadImage::find($id);
            if ($downloadImage) {
                if (strpos($downloadImage->url, "e-hentai") !== false) {
                    dispatch(new EHentaiDownloadImage($downloadImage->url, null, $downloadImage->id, true));
                } elseif (strpos($downloadImage->url, "nhentai") !== false) {
                    // dispatch(new NHentaiDownloadImage($downloadImage->url, null, $downloadImage->id));
                } elseif (strpos($downloadImage->url, "imhentai") !== false) {
                    dispatch(new ImHentaiDownloadImage($downloadImage->url, null, $downloadImage->id, true));
                } else {
                    \Log::info('item',['Filling can not found source type']);
                }
            }
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }

    public function refreshCover(Request $request)
    {
        try {
            $data = DownloadImage::whereIn('status', [0,1,2,4])->whereNull('image')->get();
            foreach ($data as $item) {
                $detail = $this->getDetailFromSource($item->url);
                $item->update([
                    'image' => $detail->image,
                    'title' => $detail->title,
                ]);
            }
        } catch (\Exception $ex) {
            \Log::info('item',[$ex]);
        }
    }

    public function retryAll(Request $request)
    {
        try {
            DB::statement('TRUNCATE TABLE jobs');
            $data = DownloadImage::whereIn('status', [0,1,2,4])->get();
            foreach ($data as $item) {
                if (strpos($item->url, "e-hentai") !== false) {
                    $job = dispatch(new EHentaiDownloadImage($item->url, null ,$item->id));
                } elseif (strpos($item->url, "nhentai") !== false) {
                    $job = dispatch(new NHentaiDownloadImage($item->url, null ,$item->id));
                } elseif (strpos($item->url, "imhentai") !== false) {
                    $job = dispatch(new ImHentaiDownloadImage($item->url, null ,$item->id));
                } else {
                    \Log::info('item',['Download can not found source type']);
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
