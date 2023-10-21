<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MangaImage extends Model
{
    protected $table = 'manga_images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'path', 'manga_id'
    ];

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'manga_id');
    }
}
