<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    //chaque order katntami l user wahd
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //chaque order momkin ikono fih plusieurs products
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    //chaque order 3ndo address shipping whda
    public function shipping()
    {
        return $this->hasOne('App\Shipping');
    }
}
