<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable=['name','msg','email','phone'];

}
