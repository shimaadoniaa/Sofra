<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    public $fillable=['name','img','details','special_order','price','price_in_offer','duration_order','restaurant_id'];

    public function offer()
    {
        return $this->belongsTo('App\Model\Offer', 'offer_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant', 'restaurant_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

}
