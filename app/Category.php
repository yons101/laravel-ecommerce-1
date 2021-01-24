<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    //chaque category momkin ikono fiha plusieurs products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
