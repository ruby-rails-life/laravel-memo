<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationHmt extends Model
{
    public function RelationHm(){
        return $this->belongsTo('App\RelationHm');
    }

    //１対１（ポリモーフィック）
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    //１対多（ポリモーフィック）
    public function thoughts()
    {
        return $this->morphMany('App\Thought', 'thoughtable');
    }
}
