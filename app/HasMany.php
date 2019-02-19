<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasMany extends Model
{
    public function Clover(){
        return $this->belongsTo('App\Clover','clover_name','clover_name');
    }
}
