<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceParticipant extends Model
{
    protected $table = 'workspace_participant';
    protected $fillable = [
        'id', 'workspace_id', 'user_id', "created_at", "updated_at"
    ];
    public function user()
    {
        return $this->hasMany('App\User',"id","user_id")->select('id','name');
    }
    public function workspace()
    {
        return $this->hasMany('App\Workspace',"id","workspace_id");
    }
}
