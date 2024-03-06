<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadImage extends Model
{
    protected $table = 'download_images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'url', 'status', 'total', 'total', 'completed',
    ];
}
