<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thought extends Model
{
    protected $guarded = ['id']; 
    
    public function thoughtable()
    {
        return $this->morphTo();
    }
}
