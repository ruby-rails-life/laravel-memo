<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationNullable extends Model
{
    /**
     * 全リレーションをtouch
     *
     * @var array
     */
    protected $touches = ['relationMtm'];

    public function RelationMtm(){
        return $this->belongsTo('App\RelationMtm')->withDefault([
            'name' => 'Guest Author',
        ]);
    }
}
