<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Paid extends Model
{

    protected $table = 'paids';
    public $timestamps = true;
    protected $guarded=[];

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant', 'restaurant_id');
    }

}
