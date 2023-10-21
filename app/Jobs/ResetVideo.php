<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Video;
class ResetVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $groupMedias;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($groupMedias)
    {
        $this->groupMedias = $groupMedias;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $videos = Video::where("extension","mp4")
            ->where('path', 'like', $this->groupMedias->path . '%')
            ->get();

            foreach
        \Log::info('item',[$videos]);
        
        $path = storage_path() . "/app/public/videos/video";
        $arrPath = array_unique($this->looping($path));
        $this->renewVideoPath($arrPath);
        $this->info("success");
    }
}
