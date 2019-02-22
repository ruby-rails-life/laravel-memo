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

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getNameUpdatedAtAttribute()
    {
        return "{$this->name}:{$this->updated_at}";
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    
    public function RelationMtm(){
        return $this->belongsTo('App\RelationMtm')->withDefault([
            'name' => 'Guest Author',
        ]);
    }
}
