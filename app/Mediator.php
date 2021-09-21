<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mediator extends Model
{
    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
        'is_active',
        'sort_id',
        'created_at_np',
        'created_by',
        'updated_by',
    ];
}
