<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    
    protected $fillable = [
        'id', 'list_id', 'title', 'rank', "created_at", "updated_at"
    ];
    public function listTask()
    {
        return $this->belongsTo('App\listTask',"id");
    }
}
