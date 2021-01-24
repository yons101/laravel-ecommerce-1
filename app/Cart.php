<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    //chaque panier katntami l user wahd
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //chaque panier momkin ikono fiha plusieurs products
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
