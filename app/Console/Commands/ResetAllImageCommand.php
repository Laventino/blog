<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use VideoThumbnail;
use App\Image;
use App\GroupMedia;
use Illuminate\Support\Facades\DB;

class ResetAllImageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all image';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $groupMedia = GroupMedia::get();
        DB::table('image')->delete();
        DB::statement("ALTER TABLE image AUTO_INCREMENT =  1");
        foreach ($groupMedia as $key => $item) {
            $path = storage_path() . "/app/public" . $item->path;
            $arrPath = array_unique($this->looping($path));
            $this->renewImagePath($arrPath,$item->id);
        }
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
            if(in_array($ext, array("jpg","JPG","png","PNG"))){
                array_push($arr, substr($path,strlen(storage_path().'/app/public')).'/'.$file);
            }
        }
        $arr = array_merge($arr, $arr_in_file);
        return $arr;
    }

    public function renewImagePath($arrPath, $groupId){
        $arr = [];
        foreach ($arrPath as $key => $value) {
            $extension = pathinfo(storage_path($value), PATHINFO_EXTENSION);
            $path = storage_path('app\public'.$value);
            $name = pathinfo(storage_path() . '/app/public' . $value, PATHINFO_BASENAME);
            $arr[] = [
                'name' => $name,
                'path' => $value,
                'extension' => $extension,
                'group_id' => $groupId
            ];
        }
        Image::insert($arr);
    }
}
