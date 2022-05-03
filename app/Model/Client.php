<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable=['phone','distriction_id','email','name','pin_code'];
    protected $hidden=['password','api_token'];

    public function order()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function tokens()
    {
        return $this->hasMany('App\Model\Token');
    }

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City', 'city_id');
    }

    public function distriction()
    {
        return $this->belongsTo('App\Model\Distriction', 'distriction_id');
    }

    public function notificationable()
    {
        return $this->morphMany('App\Model\Notificationable', 'notificationable');
    }

}
