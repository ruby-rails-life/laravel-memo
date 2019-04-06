<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public function Sales(){
        return $this->belongsTo('App\User','sales_staff_id','id');
    }

    public function Developer(){
        return $this->belongsTo('App\User','developer_in_charge_id','id');
    }
}
