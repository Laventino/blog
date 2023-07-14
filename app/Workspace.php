<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $table = 'workspace';
    protected $fillable = [
        'id', 'user_id', 'title', "created_at", "updated_at"
    ];
    public function list_tasks()
    {
        return $this->hasMany('App\ListTasks',"workspace_id");
    }
   
    public function workspace_participant()
    {
        return $this->belongsTo('App\WorkspaceParticipant',"workspace_id");
    }

    public function user()
    {
        return $this->hasMany('App\User',"id","user_id")->select('id','name');
    }
}
