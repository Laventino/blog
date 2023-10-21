<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use VideoThumbnail;
use App\Video;
use Illuminate\Support\Facades\DB;

class ResetAllVideoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all video';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path() . "/app/public/videos/video";
        $arrPath = array_unique($this->looping($path));
        $this->renewVideoPath($arrPath);
        $this->info("success");
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
        $arr = [];
        $thumbnail_path   = storage_path().'\app\public\thumbnail';

        foreach(glob($thumbnail_path.'\*.*') as $v){
            unlink($v);
        }

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

            $arr[] = [
                'name' => $name,
                'path' => $value,
                'extension' => $extension,
                'duration' => $duration,
                'cover_path' => $cover_path
            ];
        }
        DB::table('video')->delete();
        DB::statement("ALTER TABLE video AUTO_INCREMENT =  1");
        Video::insert($arr);
    }
}
