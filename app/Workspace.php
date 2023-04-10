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
        return $this->hasMany('App\WorkspaceParticipant',"workspace_id");
    }
}
