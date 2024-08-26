<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


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
        $path = storage_path() . "/app/public/videos/video/convert/original";
        $arrPath = array_unique($this->looping($path));
        $this->convertVideo($arrPath);
        // $this->cutVideo($arrPath);
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

    public function cutVideo($arrPath){
         $ffmpegCommand = "ffmpeg -i 'D:\File\song\anime\m\video\convert\merge\asdasd-1.mkv' -i 'D:\File\song\anime\m\video\convert\merge\asdasd-3.mkv' -filter_complex '[0:v:0][0:a:0][1:v:0][1:a:0]concat=n=2:v=1:a=1[outv][outa]' -map '[outv]' -map '[outa]' 'D:\File\song\anime\m\video\convert\merge\merge.mkv'";
        // Execute the FFmpeg command
        exec($ffmpegCommand);
        // $fileName = null;
        // // Path to the FFmpeg binary
        // $ffmpegPath = 'C:/ffmpeg/bin/ffmpeg.exe';
        // $segment1 = '"C:/Users/lymen/Documents/GitHub/blog/storage/app/public/videos/video/convert/converted/segment1.mp4"';
        // $segment2 = '"C:/Users/lymen/Documents/GitHub/blog/storage/app/public/videos/video/convert/converted/segment2.mp4"';
        try {
            foreach ($arrPath as $key => $value) {
                // $fileName = $value;
        
                // // Path to the .ts input file
                // $inputFile = '"C:/Users/lymen/Documents/GitHub/blog/storage/app/public/videos/video/convert/original/' . $value .'"';
            
                // // Path to the output .mp4 file
                // $outputFile = '"C:/Users/lymen/Documents/GitHub/blog/storage/app/public/videos/video/convert/converted/' . pathinfo(basename($value), PATHINFO_FILENAME) .'.mp4"';
                // \Log::info('item',[$outputFile]);
    
    
                // Command to execute
                // $command = "$ffmpegPath -i $inputFile -ss 00:22:38 -t 00:22:56 -c copy $outputFile";
                // $command = "$ffmpegPath -i $inputFile -ss 11 -c copy $outputFile";
                // $command = "$ffmpegPath -i $inputFile -c:v copy -c:a copy $outputFile";

            
                // // Extract the first segment from the start to 22 minutes and 22 seconds
                // $ffmpegCommand1 = "ffmpeg -i $inputFile -t 00:22:38 -c copy $segment1";
                // exec($ffmpegCommand1);
            
                // // Extract the second segment from 22 minutes and 50 seconds to the end
                // $ffmpegCommand2 = "ffmpeg -ss 00:22:56 -i $inputFile -c copy $segment2";
                // exec($ffmpegCommand2);
            
                // Concatenate the two segments
                // $concatCommand = "ffmpeg -i concat:$segment1|$segment2 -c copy $outputFile";
                // exec($concatCommand);
            
                // Remove the temporary segment files
                // unlink($segment1);
                // unlink($segment2);

            
                // Create a temporary concat list file
                // $concatList = "concat.txt";
                // file_put_contents($concatList, "file '$segment1'\nfile '$segment2'");
            
                // Use FFmpeg to concatenate the segments using the concat filter
                // $ffmpegCommand = "ffmpeg -f concat -safe 0 -i $concatList -c copy $outputFile";
                // exec($ffmpegCommand);


                // FFmpeg command to concatenate two videos
                // $ffmpegCommand = "ffmpeg -i $segment1 -i $segment2 -filter_complex '[0:v:0][0:a:0][1:v:0][1:a:0]concat=n=2:v=1:a=1[outv][outa]' -map '[outv]' -map '[outa]' -c:v libx264 -c:a aac $outputFile";
                // $ffmpegCommand = "ffmpeg -i $segment1 -i $segment2 -filter_complex concat=n=2:v=1:a=1 $outputFile";
                // $ffmpegCommand = "ffmpeg -i 'D:\File\song\anime\m\video\convert\merge\asdasd-1.mkv' -i 'D:\File\song\anime\m\video\convert\merge\asdasd-3.mkv' -filter_complex '[0:v:0][0:a:0][1:v:0][1:a:0]concat=n=2:v=1:a=1[outv][outa]' -map '[outv]' -map '[outa]' 'D:\File\song\anime\m\video\convert\merge\merge.mkv'";
                // // Execute the FFmpeg command
                // exec($ffmpegCommand);


                // Execute the command
                // exec($command);
            }
        } catch (\Throwable $th) {
            \Log::info('item',[$fileName]);
            \Log::info('item',[$th]);
        }
    }
}
