<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MergeVideoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'merge:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $directory = storage_path("\\app\\public\\videos\\video\\convert\\merge");

        // Scan the directory and filter out only directories
        $folders = array_filter(scandir($directory), function($item) use ($directory) {
            return is_dir($directory . DIRECTORY_SEPARATOR . $item) && !in_array($item, ['.', '..']);
        });
        
        // Output the list of folders
        foreach ($folders as $folder) {
            $this->merging($directory.'\\'.$folder, $folder);
        }
    }
    public function merging($path, $name){
        // $path = storage_path() . "/app/public/videos/video/convert/merge";
        $ds = storage_path() . "\\app\\public\\videos\\video\\convert\\merged\\$name.mp4";
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
                array_push($arr, substr($path,strlen(storage_path().'/app/public/videos/video/convert/original')).$file);
            }
        }
        $arr = array_merge($arr, $arr_in_file);
        return $arr;
    }
}
