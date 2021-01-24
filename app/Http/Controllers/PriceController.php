<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class PriceController extends Controller
{

    //route GET /price/{mix}/{max}
    public function show($minPrice, $maxPrice)
    {
        //jib les products li bin minPrice et maxPrice
        //pagiantion par 12
        $products = Product::whereBetween('price', [$minPrice, $maxPrice])->latest()->paginate(12);

        //afficher lview li kayna fi /resources/views/products/index.blade.php 
        //osift lya m3aha les variables 'products'
        return view('products.index', compact(['products']));
    }
}
