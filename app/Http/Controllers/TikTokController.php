<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ssovit\TikTokApi\TikTokApi;




class TikTokController extends Controller
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
    
    public function download($videoId)
    {
        // $api = new \Sovit\TikTok\Api();
        // $result = $api->getVideoByUrl("https://www.tiktok.com/@zachking/video/6829303572832750853");
        // $downloader=new \Sovit\TikTok\Download();
        // \Log::info('item',[$result]);
        // $downloader->url($result->items[0]->video->playAddr,"video-file",'mp4');

        header("Content-Type: application/json");
        $api = new \Sovit\TikTok\Api();
        $result = $api->getVideoByID("6829540826570296577");
        echo json_encode($result,JSON_PRETTY_PRINT);
        // $api = new TikTokApi();
        // $videoUrl = $api->getVideoDownloadUrl($videoId);
        
        // if ($videoUrl) {
        //     return redirect()->away($videoUrl);
        // }
        
        // return back()->with('error', 'Failed to download TikTok video');
    }
}