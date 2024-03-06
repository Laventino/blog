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
        $url = "https://e-hentai.org/g/2836042/c7d58b2ce1/";

        $parsedUrl = parse_url($url);
        $path = rtrim($parsedUrl['path'], '/');
        $baseUrl = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $path;

        $htmlListPage = Http::withOptions(['verify' => false])->get($baseUrl . '/?nw=always');
        preg_match('/<h1\s+id="gn">(.*?)<\/h1>/', $htmlListPage, $matchesTile);
        $title = isset($matchesTile[1]) ? $matchesTile[1] : '';

        $storagePath = storage_path('/app/public/videos/PT/manga/e/' . $title);
        if (!File::isDirectory($storagePath)) {
            File::makeDirectory($storagePath, 0777, true, true);
        }
    
        $patternPagination = '/<table[^>]*class\s*=\s*["\'](?:[^"\']*\s+)?ptt(?:[^"\']*["\'])[^>]*>.*?<\/table>/is';
        preg_match($patternPagination, $htmlListPage, $matchesPagination);
        $tableHtml = isset($matchesPagination[0]) ? $matchesPagination[0] : '';
        
        $links = [];
        if (!empty($tableHtml)) {
            preg_match_all('/<a[^>]*href\s*=\s*["\']([^"\']*)["\'][^>]*>/i', $tableHtml, $aMatches);
            $links = $aMatches[1];
        }
        if (count($links) > 1) {
            array_pop($links);
        }
        
        $linkImagePages = [];
        foreach ($links as $link) {
            $htmlListPage = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Cookie' => 'nw=1;'
                ])
                ->get($link);
            preg_match_all('/<a\s+(?:[^>]*?\s+)?href=(["\'])(https:\/\/e-hentai\.org\/s\/[^"\']*)\1[^>]*>/', $htmlListPage, $matchesImagePage);
            $linkImagePages = array_merge($linkImagePages, $matchesImagePage[2]);
        }

        foreach ($linkImagePages as $key => $link) {
            $htmlImagePage = Http::withOptions(['verify' => false])->get($link);
            preg_match('/<img\s+id="img"\s+src="([^"]+)"/', $htmlImagePage, $matches);
            $imageUrl = isset($matches[1]) ? $matches[1] : '';
            $localPath = $key . '.jpg';
            $directory = '/public/videos/PT/manga/e/' . $title . '/' . $localPath;
            $imageData = file_get_contents($imageUrl);
            if ($imageData !== false) {
                Storage::put($directory, $imageData);
            }
        }











        // $localPath = $title;

        // $storagePath = storage_path('/app/public/videos/PT/manga/e/' . $localPath);

        // if (!File::isDirectory($storagePath)) {
        //     File::makeDirectory($storagePath, 0777, true, true);
        //     echo "Folder created successfully.";
        // } else {
        //     echo "Folder already exists.";
        // }






        // $response = Http::withOptions(['verify' => false])->get('https://e-hentai.org/g/2836042/c7d58b2ce1/?nw=always');
        // \Log::info('item',[$response]);















        

        // $imageUrl = 'https://dvagnph.ysfsdtvjdthh.hath.network:9487/h/b9d2a35df173fa252657528f21834ca037832db7-305593-1024-1024-jpg/keystamp=1709557500-8d554aa6de;fileindex=144193054;xres=org/115739064_p0.jpg';
        // $localPath = '/asdasdasd.jpg';

        // $imageData = file_get_contents($imageUrl);

        // if ($imageData !== false) {
        //     $storagePath = storage_path('app/' . $localPath);
        //     \Log::info('item', [$storagePath]);
        //     Storage::put($localPath, $imageData);
        // }
    }
}