<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    //chaque product momkin it ajouta lbzaf d les paniers
    public function carts()
    {
        return $this->belongsToMany('App\Cart');
    }

    //chaque product momkin ikon f bzaf d les orders
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    //chaque product kayntami l category whda
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
