<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkCategory extends Model
{
    protected $table = 'mark_categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'text',
    ];


}
