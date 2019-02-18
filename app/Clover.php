<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clover extends Model
{
    use SoftDeletes;

    protected $table = 'my_clovers';
    protected $primaryKey = 'clover_name';
    protected $keyType = 'string';

    public $incrementing = false;
    
    //自動更新をEloquentにしてほしくない場合
    //public $timestamps = false;

    //protected $dateFormat = 'U';

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    protected $attributes = [
        'active' => true,
    ];

    //protected $fillable = ['clover_name'];

    /**
     * 複数代入しない属性
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
