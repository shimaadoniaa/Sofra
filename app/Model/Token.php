<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable=['token','type','client-id','restaurant_id'];

    public function client()
    {
        return $this->belongsTo('App\Model\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Client');
    }

}
