<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use VideoThumbnail;
use App\Video;
use Illuminate\Support\Facades\DB;

class ConvertVideoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all video';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path() . "/app/public/videos/video/convert/original";
        $arrPath = array_unique($this->looping($path));
        $this->convertVideo($arrPath);
        $this->info("success");
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
            if(in_array($ext, array("ts","TS","mp4","MP4","M4V","m4v","MOV","mov"))){
                array_push($arr, substr($path,strlen(storage_path().'/app/public/videos/video/convert/original')).$file);
            }
        }
        $arr = array_merge($arr, $arr_in_file);
        return $arr;
    }

    public function convertVideo($arrPath){
        $fileName = null;
        try {
            foreach ($arrPath as $key => $value) {
                $fileName = $value;
                // Path to the FFmpeg binary
                $ffmpegPath = 'C:/ffmpeg/bin/ffmpeg.exe';
        
                // Path to the .ts input file
                $inputFile = '"C:/Users/lymen/Documents/GitHub/blog/storage/app/public/videos/video/convert/original/' . $value .'"';
            
                // Path to the output .mp4 file
                $outputFile = '"C:/Users/lymen/Documents/GitHub/blog/storage/app/public/videos/video/convert/converted/' . pathinfo(basename($value), PATHINFO_FILENAME) .'.mp4"';
    
                // Command to execute
                $command = "$ffmpegPath -i $inputFile -c:v copy -c:a copy $outputFile";
    
                // Execute the command
                exec($command);
            }
        } catch (\Throwable $th) {
            \Log::info('item',[$fileName]);
            \Log::info('item',[$th]);
        }
    }
}
