<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_Declined = 4;
    const STATUS_Confirmed = 4;
    const STATUS_Cart = 5;

    protected $table = 'orders';
    public $timestamps = true;
    protected $guarded =[];

    public function Client()
    {
        return $this->belongsTo('App\Model\Client', 'client_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant', 'restaurant_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product')->withPivot('amount','notes');
    }

    public function payment()
    {
        return $this->belongsTo('App\Model\Payment');
    }

}
