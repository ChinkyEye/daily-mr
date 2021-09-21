<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $fillable = [
        'client_id','hosted_on','agreement_on','server','latest_renew_date','link','is_active','created_at_np','created_by','updated_by',
    ];
}
