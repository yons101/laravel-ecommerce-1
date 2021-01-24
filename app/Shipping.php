<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    //chaque shipping address concerne un seul order
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
