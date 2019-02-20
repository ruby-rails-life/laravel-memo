<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationHm extends Model
{
    public function Clover(){
        return $this->belongsTo('App\Clover','clover_name','clover_name');
    }
}
