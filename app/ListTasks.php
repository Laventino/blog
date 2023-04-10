<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListTasks extends Model
{
    protected $table = 'list_tasks';
    protected $fillable = [
        'id','workspace_id', 'title', 'rank', "created_at", "updated_at"
    ];
    public function tasks()
    {
        return $this->hasMany('App\Tasks',"list_id")->where("archive",0)->orderBy('rank', 'asc');
    }
    public function workspace()
    {
        return $this->belongsTo('App\workspace',"id");
    }
}
