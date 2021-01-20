<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function carts()
    {
        return $this->belongsToMany('App\Cart');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }
}
