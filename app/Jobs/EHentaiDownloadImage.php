<?php

namespace App\Jobs;

use App\DownloadImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;


class EHentaiDownloadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;
    private $skip;
    private $downloadId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $skip = null, $downloadId = null)
    {
        $this->url = $url;
        $this->skip = $skip;
        $this->downloadId = $downloadId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = $this->url;
        $skip = $this->skip;
        $downloadIdImage = null;
        if ($this->downloadId) {
            $downloadIdImage = DownloadImage::find($this->downloadId);
            $downloadIdImage->update([
                'status' => 1
            ]);
        }

        $parsedUrl = parse_url($url);
        $path = rtrim($parsedUrl['path'], '/');
        $baseUrl = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $path;

        $htmlListPage = Http::withOptions(['verify' => false])->get($baseUrl . '/?nw=always');
        preg_match('/<h1\s+id="gn">(.*?)<\/h1>/', $htmlListPage, $matchesTile);
        $title = isset($matchesTile[1]) ? $matchesTile[1] : '';

        $startPos = strpos($htmlListPage, '<p class="gpc">');
        $endPos = strpos($htmlListPage, '</p>', $startPos);
        $pTagContent = substr($htmlListPage, $startPos, $endPos - $startPos + 4);

        preg_match("/Showing \d+ - \d+ of ([\d,]+) images/", $pTagContent, $matches);

        $totalImage = str_replace(',', '', $matches[1]);
        $totalImage = intval($totalImage);

        if ($downloadIdImage) {
            $downloadIdImage->update([
                'url' => $baseUrl,
                'title' => $title,
                'total' => $totalImage
            ]);
        }
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
        $lastItem = end($links);
        $queryString = parse_url($lastItem, PHP_URL_QUERY);
        parse_str($queryString, $params);
        $totalPage = isset($params['p']) ? (int) $params['p'] : null;

        $linkImagePages = [];
        for ($i=0; $i <= $totalPage; $i++) { 
            $page = $i != 0 ? '/?p=' . $i : '';
            $htmlListPage = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Cookie' => 'nw=1;'
                ])
                ->get($baseUrl . $page);
            preg_match_all('/<a\s+(?:[^>]*?\s+)?href=(["\'])(https:\/\/e-hentai\.org\/s\/[^"\']*)\1[^>]*>/', $htmlListPage, $matchesImagePage);
            $linkImagePages = array_merge($linkImagePages, $matchesImagePage[2]);
        }
        
        $completed_count = 0;

        foreach ($linkImagePages as $key => $link) {
            if ($skip && $key < $skip) {
                continue;
            } 
            $isSuccess = false;
            $imageData = null;
            $nl = null;
            try {
                $htmlImagePage = Http::withOptions(['verify' => false])->get($link);
                preg_match('/<img\s+id="img"\s+src="([^"]+)"/', $htmlImagePage, $matches);
                $imageUrl = isset($matches[1]) ? $matches[1] : '';
                $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
                $localPath = $key . '.' . $extension;
                $directory = '/public/videos/PT/manga/e/' . $title . '/' . $localPath;
                preg_match("/nl\('([^']+)'\)/", $htmlImagePage, $matches);
                $nl = $matches[1];
                $imageData = file_get_contents($imageUrl);
                if ($imageData !== false) {
                    Storage::put($directory, $imageData);
                }
                $isSuccess = true;
                $completed_count++;
            } catch (\Throwable $th) {
                logger($th);
                $imageData = false;
            }
            if (!$isSuccess && $nl != null) {
                try {
                    $htmlImagePage = Http::withOptions(['verify' => false])->get($link . '?nl=' . $nl );
                    preg_match('/<img\s+id="img"\s+src="([^"]+)"/', $htmlImagePage, $matches);
                    $imageUrl = isset($matches[1]) ? $matches[1] : '';
                    $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
                    $localPath = $key . '.' . $extension;
                    $directory = '/public/videos/PT/manga/e/' . $title . '/' . $localPath;
                    $imageData = file_get_contents($imageUrl);
                    if ($imageData !== false) {
                        Storage::put($directory, $imageData);
                    }
                    $isSuccess = true;
                    $completed_count++;
                } catch (\Throwable $th) {
                    logger($th);
                }
            }
        }

        if ($downloadIdImage) {
            $status = 4;
            if ($totalImage == $completed_count) {
                $status = 3;
            }
            $downloadIdImage->update([
                'completed' => $completed_count,
                'status' => $status,
            ]);
        }
    }
}
