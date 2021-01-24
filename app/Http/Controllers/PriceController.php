<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function show($minPrice, $maxPrice)
    {
        $products = Product::whereBetween('price', [$minPrice, $maxPrice])->latest()->paginate(12);

        return view('products.index', compact(['products']))
            ->with((request()->input('page', 1) - 1) * 12);
    }
}
