<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Video;
use VideoThumbnail;
use Illuminate\Support\Facades\DB;

class ResetVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $groupMedias;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($groupMedias)
    {
        $this->groupMedias = $groupMedias;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $videos = Video::where("extension","mp4")
            ->where('path', 'like', $this->groupMedias->path . '%')
            ->get();

        foreach ($videos as $key => $video) {
            $thumbnail_path   = storage_path().'\app\public\thumbnail';
            $coverPath = $thumbnail_path . $video->cover_path . '.jpg';
            if (file_exists($coverPath)) {
                unlink($coverPath);
            }
            $video->delete();
        }
        
        $path = storage_path() . "/app/public" . $this->groupMedias->path;
        $arrPath = array_unique($this->looping($path));
        $this->renewVideoPath($arrPath);
    }

    public function looping($path){
        $arr =  array();
        $arr_in_file = array();

        foreach(scandir($path) as $file) {
            if($file == "." || $file == ".." || $file == "web" || $file == 'PT'){
                continue;
            }
            if(is_dir($path.'/'.$file)){
                $arr_in_file = array_merge($arr_in_file, $this->looping($path.'/'.$file));
            }
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if(in_array($ext, array("mp4","MP4"))){
                array_push($arr, substr($path,strlen(storage_path().'/app/public')).'/'.$file);
            }
        }
        $arr = array_merge($arr, $arr_in_file);
        return $arr;
    }

    public function renewVideoPath($arrPath){
        $thumbnail_path   = storage_path().'\app\public\thumbnail';

        foreach ($arrPath as $key => $value) {
            $extension = pathinfo(storage_path($value), PATHINFO_EXTENSION);
            $thumbnail_image  = ($key + 1) . ".jpg";
            $path = storage_path('app\public'.$value);
            $getID3 = new \getID3;
            $video_file = $getID3->analyze($path);
            $cover_path = null;
            $name = pathinfo(storage_path() . '/app/public' . $value, PATHINFO_BASENAME);

            if(!isset($video_file['error']) ){
                $cover_path = $key + 1;
                $time_to_image    = floor(($video_file['playtime_seconds'])/2);
                $videoUrl = storage_path('app\public'.$value);
                VideoThumbnail::createThumbnail(
                    $videoUrl,
                    $thumbnail_path,
                    $thumbnail_image,
                    $time_to_image,
                    $width = 640,
                    $height = 480
                );
            }

            $duration = null;
            if(array_key_exists('playtime_string', $video_file)){
                $duration = $video_file['playtime_string'];
            }

            Video::create([
                'name' => $name,
                'path' => $value,
                'extension' => $extension,
                'duration' => $duration,
                'cover_path' => $cover_path
            ]);
        }
    }
}
