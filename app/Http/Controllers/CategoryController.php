<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($title)
    {
        $products = Product::where('title', 'like', "%$title%")->latest()->paginate(12);

        return view('products.index', compact(['products', 'title']))
            ->with((request()->input('page', 1) - 1) * 12);
    }
}
