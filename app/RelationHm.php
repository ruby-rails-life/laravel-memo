<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationHm extends Model
{
    public function Clover(){
        return $this->belongsTo('App\Clover','clover_name','clover_name');
    }

    public function RelationHmts() {
        return $this->hasMany('App\RelationHmt');
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
    //多対多（ポリモーフィック）
    //第一引数 - 結合先モデル
    //第二引数 - 中間テーブルtypeカラムのプレフィックス
    //第三引数 - 中間テーブル名
    //第四引数 - 結合元モデルと結合させる中間テーブルのカラム
    //第五引数 - 結合先モデルと結合させる中間テーブルのカラム
    //第六引数 - 結合元モデルの結合カラム
    //第七引数 - 結合先モデルの結合カラム
    //第八引数 - リレーションの逆を接続しているか。設定はbool値。デフォルトはfalse
    public function categories()
    {
        return $this->morphToMany(
        	'App\Category', 
        	'categorizable',
        	'categorizables',
        	'categorizable_id',
        	'category_id',
        	'id',
        	'id',
        	false
        );
    }
}
