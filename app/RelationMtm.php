<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationMtm extends Model
{
    //多対多（ポリモーフィック）
    public function categories()
    {
        return $this->morphToMany('App\Category', 'categorizable');
    }
}
