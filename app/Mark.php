<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table = 'mark';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;

    protected $fillable = [
        'id', 'category', 'item_id', 'type', 'status', 'created_at',
    ];

    public function mark_category()
    {
        return $this->belongsTo(MarkCategory::class, 'type', 'id');
    }

    public function getMarkTextAttribute()
    {
        return $this->mark_category()->first()->text;
    }

    public function getMarkNameAttribute()
    {
        return $this->mark_category()->first()->name;
    }
}
