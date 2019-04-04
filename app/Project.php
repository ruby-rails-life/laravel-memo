<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function Sales(){
        return $this->belongsTo('App\User','sales_staff_id','id');
    }

    public function Developer(){
        return $this->belongsTo('App\User','developer_in_charge_id','id');
    }
}
