<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MergeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $folderCount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $directory = storage_path("app\\public\\videos\\video\\convert\\merge");
        $this->folderCount = count(glob($directory . '/*', GLOB_ONLYDIR));
        // Scan the directory and filter out only directories
        $folders = array_filter(scandir($directory), function($item) use ($directory) {
            return is_dir($directory . DIRECTORY_SEPARATOR . $item) && !in_array($item, ['.', '..']);
        });
        
        // Output the list of folders
        foreach ($folders as $folder) {
            $this->merging($directory.'\\'.$folder, $folder);
        }
    }
    function generateRandomString($length = 16) {
        return bin2hex(random_bytes($length / 2));
    }
    public function merging($path, $name){
        // $path = storage_path() . "/app/public/videos/video/convert/merge";
        $randomString = $this->generateRandomString(16);
        $ds = storage_path("app\\public\\videos\\video\\convert\\merged\\$randomString.mp4");
        $arrPath = array_unique($this->looping($path));
        $stringMerge = '';
        foreach ($arrPath as $key => $value) {
            $dir = storage_path() . "\\app\\public\\videos\\video\\convert\\merge\\$name\\$value";
            $stringMerge .= $stringMerge == '' ? $dir : '|'.$dir;
        }
        if ($stringMerge != "") {
            $ffmpegCommand = "ffmpeg -i concat:\"$stringMerge\" -c copy \"$ds\" 2>&1";
            exec($ffmpegCommand);
        }
    }
    public function looping($path){
        $arr =  array();
        $arr_in_file = array();

        foreach(scandir($path) as $file) {
            if($file == "." || $file == ".."){
                continue;
            }
            if(is_dir($path.'/'.$file)){
                $arr_in_file = array_merge($arr_in_file, $this->looping($path.'/'.$file));
            }
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if(in_array($ext, array("ts","TS","mp4","MP4","M4V","m4v","MOV","mov","mkv","MKV"))){
                array_push($arr, $file);
            }
        }
        $arr = array_merge($arr, $arr_in_file);
        return $arr;
    }
}
