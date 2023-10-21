<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use VideoThumbnail;
use App\Manga;
use App\MangaImage;
use Illuminate\Support\Facades\DB;

class ResetAllMangaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:manga';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all manga';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path() . "/app/public/videos/PT/manga";
        $mapPath = $this->looping($path);
        $this->renewMangaPath($mapPath);
        // $this->info("success");
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
                $_name = $name;

                $manga = [
                    'name'  => $_name,
                    'path'  => "",
                    'cover' => "",
                    'genre' => $_genre,
                ];
                $mangaModel = Manga::create($manga);
                foreach ($mangas as $image_name => $image) {
                    $_image_name = $image_name;

                    // $mangaListImage[] = [
                    //     'name'      => $image['name'],
                    //     'path'      => $image['path'],
                    //     'manga_id'  => $mangaModel->id,
                    // ];
                    MangaImage::insert([
                        'name'      => $image['name'],
                        'path'      => $image['path'],
                        'manga_id'  => $mangaModel->id,
                    ]);
                }
            }
        }
        // MangaImage::insert($mangaListImage);
    }
}
