<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationHmt extends Model
{
    public function RelationHm(){
        return $this->belongsTo('App\RelationHm');
    }
}
