<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable=['name'];

    public function restaurants()
    {
        return $this->belongsToMany('App\Model\Restaurant');
    }

}
