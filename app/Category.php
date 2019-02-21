<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function relationHms()
    {
        return $this->morphedByMany('App\RelationHm', 'categorizable');
    }

    public function relationMtms()
    {
        return $this->morphedByMany('App\RelationMtm', 'categorizable');
    }
}
