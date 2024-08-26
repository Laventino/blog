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
use Illuminate\Queue\MaxAttemptsExceededException;

class ImHentaiDownloadImage implements ShouldQueue
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
      
        $url_parts = explode('/', $baseUrl);
        $galleryId = end($url_parts);

        $htmlListPage = Http::withOptions(['verify' => false])->get($baseUrl);
        preg_match('/<div class="col-md-7 col-sm-7 col-lg-8 right_details">\s*<h1>(.*?)<\/h1>/s', $htmlListPage, $matchesTile);
        $titleRaw = isset($matchesTile[1]) ? $matchesTile[1] : '';
        $title = str_replace(array(":", " |", "|", "?", ",", "."), "", urldecode(html_entity_decode($titleRaw)));
        // Manually decode the HTML entity
        $title = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $title);
        $totalImage = 0;
        $pattern = '/<ul class="galleries_info">.*?<li class="pages">(.*?)<\/li>/s';
        preg_match($pattern, $htmlListPage, $matches);
        $totalImage =  $matches[1];
        preg_match('/Pages:\s*(\d+)/', $totalImage, $matches);
        $totalImage = $matches[1];


        if ($downloadIdImage) {
            $downloadIdImage->update([
                'url' => $baseUrl,
                'title' => $title,
                'total' => $totalImage,
                'status' => 2
            ]);
        }

        $storagePath = storage_path('/app/public/videos/PT/manga/im/' . $title);
        if (!File::isDirectory($storagePath)) {
            File::makeDirectory($storagePath, 0777, true, true);
        }

        $completed_count = $skip ?? 0;

        for ($i= ($skip ? $skip : 1); $i <= $totalImage; $i++) { 
            $isSuccess = false;
            $imageUrl = '';
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
            } catch (MaxAttemptsExceededException $th) {
                logger($imageUrl);
                logger($th);
                $imageData = false;
            } catch (\Throwable $th) {
                logger($imageUrl);
                logger($th);
                $imageData = false;
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