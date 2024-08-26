<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        $url = 'https://imhentai.xxx/gallery/1210550/';
        $skip = null;

        $parsedUrl = parse_url($url);
        $path = rtrim($parsedUrl['path'], '/');
        $baseUrl = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $path;
 
        $url_parts = explode('/', $baseUrl);
        $galleryId = end($url_parts);

        $htmlListPage = Http::withOptions(['verify' => false])->get($baseUrl);
        preg_match('/<div class="col-md-7 col-sm-7 col-lg-8 right_details">\s*<h1>(.*?)<\/h1>/s', $htmlListPage, $matchesTile);
        $titleRaw = isset($matchesTile[1]) ? $matchesTile[1] : '';
        // filter symbol can not use on folder
        $title = str_replace(array(":", " |", "|", "?"), "", urldecode($titleRaw));
        // \Log::info('item',[$title]);
        
        $totalImage = 0;
        $pattern = '/<ul class="galleries_info">.*?<li class="pages">(.*?)<\/li>/s';
        preg_match($pattern, $htmlListPage, $matches);
        $totalImage =  $matches[1];
        preg_match('/Pages:\s*(\d+)/', $totalImage, $matches);
        $totalImage = $matches[1];

        for ($i= ($skip ?? 1); $i <= $totalImage; $i++) { 
        // foreach ($linkImagePages as $key => $link) {
            $isSuccess = false;
            $imageData = null;
            try {
                $htmlImagePage = Http::withOptions(['verify' => false])->get('https://imhentai.xxx/view/' . $galleryId . '/' . $i);
                $pattern = '/<img\s[^>]*id="gimg"[^>]*src="([^"]*)"[^>]*>/i';
                preg_match($pattern, $htmlImagePage, $matches);
                $imageUrl = isset($matches[1]) ? $matches[1] : '';
                $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
                $localPath = $i . '.' . $extension;
                $directory = '/public/videos/PT/manga/im/' . $title . '/' . $localPath;
                $imageData = file_get_contents($imageUrl);
                if ($imageData !== false) {
                    Storage::put($directory, $imageData);
                }
                $isSuccess = true;
                $completed_count++;
                
                $downloadIdImage->update([
                    'completed' => $completed_count,
                ]);
            } catch (\Throwable $th) {
                logger($th);
                $imageData = false;
            }
        }
    }
}