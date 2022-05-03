<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable=['name','content','img','restaurant_id','from_date','to_date'];

    public function product()
    {
        return $this->hasMany('App\Model\Product');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant', 'restaurant_id');
    }

}
