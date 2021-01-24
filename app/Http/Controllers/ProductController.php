<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //route GET /products
    public function index()
    {
        //jib tous les products
        //pagination par 12
        $products = Product::paginate(12);

        //afficher lview li kayna fi /resources/views/products/index.blade.php 
        //osift lya m3aha les variables 'products'
        return view('products.index', compact('products'));
    }

    //route GET /products/{slug}
    public function show($slug)
    {
        //jib li lproduit, li slug aw url dyalo = $slug
        //sinon firstOrFail = 404
        $product = Product::where('slug', $slug)->firstOrFail();

        //jib li 4 produits, li title dyalhom, kaychbeh lproduit li m afficher
        $products = Product::where('title', 'like', "%$product->title%")->inRandomOrder()->take(4)->get();

        //afficher lview li kayna fi /resources/views/products/show.blade.php 
        //osift lya m3aha les variables 'products', 'product'
        return view('products.show', compact(['products', 'product']));
    }
}
