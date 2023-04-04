<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class listTask extends Model
{

    protected $fillable = [
        'id', 'user_id', 'title', 'rank', "created_at", "updated_at"
    ];
    public function tasks()
    {
        return $this->hasMany('App\tasks',"list_id")->orderBy('rank', 'asc');
    }
}
