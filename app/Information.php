<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $fillable = [
        'client_id', 'description','mediator_id','contact_id','checkbox','first_meeting','next_meeting','priority','spend_time','allocated_time','time','is_active','sort_id','created_at_np','created_by','updated_by','count','project_id'
    ];

    public function getUser()
    {
        return $this->belongsTo('App\User','created_by','id');
    }

    public function getMediator()
    {
        return $this->belongsTo('App\Mediator','mediator_id','id');
    }

    public function getContact()
    {
        return $this->belongsTo('App\Contact','contact_id','id');
    }

    public function getProject()
    {
        return $this->belongsTo('App\Project','project_id','id');
    }
    public function getClient()
    {
        return $this->belongsTo('App\Client','client_id','id');
    }
}
