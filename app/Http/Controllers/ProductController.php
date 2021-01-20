<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        //Get the latest products in a sorted order, and paginate them in 12, then store the in the variable products 
        $products = Product::latest()->paginate(12);

        //Return the products.index view with the variable products
        return view('products.index', compact('products'));
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $products = Product::where('title', 'like', "%$product->title%")->inRandomOrder()->take(4)->get();

        return view('products.show', compact(['products', 'product']));
    }
}
