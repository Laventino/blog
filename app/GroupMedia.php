<?php

namespace App;
use App\Image;

use Illuminate\Database\Eloquent\Model;

class GroupMedia extends Model
{
    protected $table = 'group_media';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'type', 'name', 'path', 'cover_path'
    ];

    public function image()
    {
        return $this->hasMany(Image::class, 'group_id');
    }
}
