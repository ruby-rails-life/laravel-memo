<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Translation\HasLocalePreference;

class Project extends Model implements HasLocalePreference
{
    use Notifiable;
    use SoftDeletes;

    public function Sales(){
        return $this->belongsTo('App\User','sales_staff_id','id');
    }

    public function Developer(){
        return $this->belongsTo('App\User','developer_in_charge_id','id');
    }

    protected $fillable = [
        'project_name',
        'order_date', 
        'estimated_delivery_date',
        'project_status',
        'development_progress',
    ];

    /**
     * メールチャンネルに対する通知をルートする
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        //return $this->email_address;
    }

    /**
     * ユーザーの希望するローケルの取得
     *
     * @return string
     */
    public function preferredLocale()
    {
        return 'en';
    }
}
