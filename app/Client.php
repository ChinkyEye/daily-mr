<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'fullname', 'address','phone','is_active','sort_id','email','created_at_np','created_by','updated_by'
    ];

    public function getUser()
    {
        return $this->belongsTo('App\User','created_by','id');
    }

    public function getInformation()
    {
        return $this->hasMany('App\Information','client_id','id');
    }

    public function getClientInfo()
    {
        return $this->hasOne('App\ClientHasInfo','client_id','id');
    }

    public function getFirstInformation()
    {
        return $this->hasOne('App\Information','client_id','id')->where('count','1');
    }

    public function getLatest()
    {
        return $this->hasOne('App\Information','client_id','id')->latest();
    }
}
