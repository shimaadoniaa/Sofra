<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    public $timestamps = true;
    public $fillable=['email','password','phone','restaurant_name','distriction_id','minimum_order','whatsApp','img','status','delivery_fees'];

    public function City()
    {
        return $this->belongsTo('App\Model\City', 'city_id');
    }

    public function order()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function product()
    {
        return $this->hasMany('App\Model\Product');
    }
    public function tokens()
    {
        return $this->hasMany('App\Model\Token');
    }

    public function offers()
    {
        return $this->hasMany('App\Model\Offer');
    }

    public function Categories()
    {
        return $this->hasMany('App\Model\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }

    public function payment()
    {
        return $this->hasMany('App\Model\Paid');
    }

    public function Notificationable()
    {
        return $this->morphMany('App\Model\Notificationable', 'notificationable');
    }
    public function distriction()
    {
        return $this->belongsTo('App\Model\Distriction','distriction_id');
    }

}
