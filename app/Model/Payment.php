<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = true;
    protected $fillable = ['name'];

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

}
