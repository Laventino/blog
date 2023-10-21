<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    protected $table = 'manga';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'path', 'cover', 'genre'
    ];

    public function manga_images()
    {
        return $this->hasMany(MangaImage::class, 'manga_id');
    }
}
