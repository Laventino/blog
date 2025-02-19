<?php

namespace App\Console\Commands;

use App\Manga;
use App\MangaImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class x extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'x:x';

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
        function generateRandomString($length = 16) {
            return bin2hex(random_bytes($length / 2));
        }
        \Log::info('item',[generateRandomString(16)]);
        // $path = "n/Aru Kyoudai no Baai In The Case of Certain Siblings";
        // $mangaPath = storage_path() . "/app/public/videos/PT/manga/" . $path;
        // $parts = explode('/', $path);
        // $map = [];
        // $map[$parts[0]][$parts[1]] = [];
     
        // if(is_dir($mangaPath)){
        //     foreach(scandir($mangaPath) as $mangaFile) {
        //         if($mangaFile == "." || $mangaFile == ".."){
        //             continue;
        //         }
        //         $ext = pathinfo($path . '/'.$parts[0].'/'.$parts[1].'/'.$mangaFile, PATHINFO_EXTENSION);
        //         if(in_array($ext, array("zip","ZIP",""))){
        //             continue;
        //         }
        //         $name = pathinfo($path . '/'.$parts[0].'/'.$parts[1].'/'.$mangaFile, PATHINFO_FILENAME);
        //         if( $mangaFile == 'ReadMe.txt'){
        //             unlink($path . '/'.$parts[0].'/'.$parts[1].'/'.$mangaFile);
        //         }
        //         $map[$parts[0]][$parts[1]][] = [
        //             'path' => '/'.$parts[0].'/'.$parts[1].'/'.$mangaFile,
        //             'name' => $name
        //         ];
        //     }
        // }
        // $this->insertMangaPath($map);
    }

    
    private function insertMangaPath($mapPath){
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