<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable=['comment','rate','client_id','restaurant_id'];

    public function client()
    {
        return $this->belongsTo('App\Model\Client', 'client_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant', 'restaurant_id');
    }

}
