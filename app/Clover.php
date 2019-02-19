<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Builder;

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

      /**
     * モデルの「初期起動」メソッド
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);

        // static::addGlobalScope('active', function (Builder $builder) {
        //     $builder->where('active', '=', 1);
        // });
    }

    public function scopeLeaves($query)
    {
        return $query->where('leaf_num', '>=', 4);
    }

    /**
     * 指定したタイプのユーザーだけを含むクエリのスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfLeaf($query, $leaf_num)
    {
        return $query->where('leaf_num', '>=', $leaf_num);
    }

    public function HasManies() {
        return $this->hasMany('App\HasMany','clover_name');
    }

    public function ManyToManies()
    {
        return $this->belongsToMany('App\ManyToMany','clover_many_to_many','clover_name','many_to_many_id');
    }
}
