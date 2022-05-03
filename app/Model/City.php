<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $guarded=[];

    public function Clients()
    {
        return $this->hasMany('App\Model\Client');
    }

    public function restaurant()
    {
        return $this->hasMany('App\Model\Restaurant');
    }

    public function districtions()
    {
        return $this->hasMany('App\Model\Distriction');
    }

}
