<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Manga;
use App\MangaImage;

class InsertManga implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path() . "/app/public/videos/PT/manga";
        $mapPath = $this->looping($path);
        $this->renewMangaPath($mapPath);
    }

    private function looping($path){
        $arr =  array();
        $arr_in_file = array();
        $map = [];
        foreach(scandir($path) as $file) {
            if($file == "." || $file == ".."){
                continue;
            }
            // genre
            $subPath = $path.'/'.$file;
            if(is_dir($subPath)){
                $map[$file] = [];
                foreach(scandir($subPath) as $subFile) {
                    if($subFile == "." || $subFile == ".."){
                        continue;
                    }
                    // manga name
                    $mangaPath = $subPath.'/'.$subFile;
                    if(is_dir($mangaPath)){
                        $map[$file][$subFile] = [];
                        foreach(scandir($mangaPath) as $mangaFile) {
                            if($mangaFile == "." || $mangaFile == ".."){
                                continue;
                            }
                            $ext = pathinfo($path . '/'.$file.'/'.$subFile.'/'.$mangaFile, PATHINFO_EXTENSION);
                            if(in_array($ext, array("zip","ZIP",""))){
                                continue;
                            }
                            $name = pathinfo($path . '/'.$file.'/'.$subFile.'/'.$mangaFile, PATHINFO_FILENAME);
                            if( $mangaFile == 'ReadMe.txt'){
                                unlink($path . '/'.$file.'/'.$subFile.'/'.$mangaFile);
                            }
                            $map[$file][$subFile][] = [
                                'path' => '/'.$file.'/'.$subFile.'/'.$mangaFile,
                                'name' => $name
                            ];
                        }
                    }
                }
            }
        }
        return $map;
    }

    private function renewMangaPath($mapPath){
        $mangaList = [];
        $mangaListImage = [];
        $thumbnail_path   = storage_path().'\app\public\thumbnail';

        DB::table('manga')->delete();
        DB::statement("ALTER TABLE manga AUTO_INCREMENT =  1");
        DB::table('manga_images')->delete();
        DB::statement("ALTER TABLE manga_images AUTO_INCREMENT =  1");
        foreach ($mapPath as $genre => $items) {
            $_genre = $genre;
            foreach ($items as $name => $mangas) {
                $read = false;
                $groupId = 0;
                $_name = $name;
                $file = storage_path("app/public/videos/PT/manga/$_genre/$_name/info.json");
                if (file_exists($file)) {
                    $jsonString = file_get_contents($file);
                    $data = json_decode($jsonString, true);
                    if ($data === null) {
                        \Log::info('item',['Error decoding JSON.']);
                    } else {
                        $read = isset($data['viewed']) ? $data['viewed'] : false;
                        $groupId = isset($data['group_id']) ? $data['group_id'] : 0;
                    }
                } else {
                    $data = ['viewed' => false];
                    $jsonData = json_encode($data);
                    file_put_contents($file, $jsonData);
                } 
                $manga = [
                    'name'   => $_name,
                    'path'   => "app/public/videos/PT/manga/$_genre/$_name",
                    'cover'  => "",
                    'genre'  => $_genre,
                    'status' => 1,
                    'read'   => $read,
                    'total_image' => count($mangas),
                    'group_id' => $groupId,
                ];
                $mangaModel = Manga::create($manga);
                foreach ($mangas as $image_name => $image) {
                    $_image_name = $image_name;

                    MangaImage::insert([
                        'name'      => $image['name'],
                        'path'      => $image['path'],
                        'manga_id'  => $mangaModel->id,
                    ]);
                }
            }
        }
    }

}
