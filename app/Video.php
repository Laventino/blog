<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'path', 'extension', 'duration', 'cover_path',
    ];

    public function mark()
    {
        return $this->hasMany(Mark::class, 'item_id', 'id');
    }

    public function getMarkTextAttribute()
    {
        return $this->mark()->where('type', 1)->first()->mark_text;
    }
}
