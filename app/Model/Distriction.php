<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Distriction extends Model
{

    protected $table = 'districtions';
    public $timestamps = true;
    protected $fillable=['name','city_id'];

    public function Clients()
    {
        return $this->hasMany('App\Model\Client');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City', 'city_id');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Model\Restaurant');
    }

}
