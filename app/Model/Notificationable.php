<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notificationable extends Model
{

    protected $table = 'notificationables';
    public $timestamps = true;
    protected $guarded=[];


    public function restaurant()
    {
        return $this->morphMany('App\Model\Restaurant', 'notificationable');
    }

    public function Clients()
    {
        return $this->morphMany('App\Model\Client', 'notificationable');
    }

}
