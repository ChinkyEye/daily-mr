<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort_id',
        'is_active',
        'created_by',
        'updated_by',
        'updated_by',
        'created_at_np',
    ];

}
