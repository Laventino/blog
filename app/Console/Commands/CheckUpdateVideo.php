<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use VideoThumbnail;
use App\Video;
use Illuminate\Support\Facades\DB;

class CheckUpdateVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Video';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path() . "/app/public/videos";
        $arr_video_path = array_unique($this->looping($path));
        $this->updateVideoPath($arr_video_path);
        $this->removeInvalidVideoPath();
        $this->info("success");
    }

    public function updateVideoPath($arr_video_path){
        $arr = [];
        $numb_up = 1;
        $thumbnail_path   = storage_path().'\app\public\thumbnail';
        $statement = DB::select("SHOW TABLE STATUS LIKE 'video'");
        $nextId = $statement[0]->Auto_increment;
        foreach ($arr_video_path as $key => $value) {
            $isHas = Video::where("path",$value)->first();
            if(!$isHas){
                $extension = pathinfo(storage_path($value), PATHINFO_EXTENSION);
                $thumbnail_image  = $nextId . ".jpg";
                $path = storage_path('app\public'.$value);
                $getID3 = new \getID3;
                $video_file = $getID3->analyze($path);
                $cover_path = null;
                $name = pathinfo(storage_path() . '/app/public' . $value, PATHINFO_BASENAME);
                if(!isset($video_file['error']) ){
                    $cover_path = $nextId;
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
                $nextId++;
                $arr[] = [
                    'name' => $name,
                    'path' => $value,
                    'extension' => $extension,
                    'duration' => $duration,
                    'cover_path' => $cover_path
                ];
            }
        }
        Video::insert($arr);

        $array_remove_path = Video::whereNotIn('path', $arr_video_path)->get();
        foreach ($array_remove_path as $key => $value) {
            $_path = glob($thumbnail_path.'\\'.$value->cover_path.'.jpg');
            $_path && unlink($_path[0]);
            $value->delete();
        }
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

    public function removeInvalidVideoPath() {
        $videos = Video::all();
        foreach($videos as $video) {
            $videoPath = storage_path().'/app/public/'.$video->path;
            if (!file_exists($videoPath)) {
                Video::delete($video->id);
            }
        }
    }
}
