<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientHasInfo extends Model
{
    protected $fillable = [
        'client_id', 'contact_id','mediator_id','is_active','sort_id','created_at_np','created_by','updated_by'
    ];

    public function getMediator()
    {
        return $this->belongsTo('App\Mediator','mediator_id','id');
    }

    public function getContact()
    {
        return $this->belongsTo('App\Contact','contact_id','id');
    }
}
