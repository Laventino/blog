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
        'id', 'title', 'url', 'image', 'status', 'total', 'completed',
    ];

    function getStatusTextAttribute() {
        $status = config('custom.download.status');

        return  isset($this->status) && isset($status[$this->status]) ? $status[$this->status] : null;
    }
}
