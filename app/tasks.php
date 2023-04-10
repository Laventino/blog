<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
        'id', 'list_id', 'title', 'rank', "created_at", "updated_at"
    ];
    public function ListTasks()
    {
        return $this->belongsTo('App\ListTasks',"id");
    }
}
