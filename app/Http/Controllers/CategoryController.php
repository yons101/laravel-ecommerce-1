<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    //route GET /category/{title}
    public function show($title)
    {
        //jib description dyal la category, li titre dyal smitha $title
        $description = Category::where('title', 'like', "%$title%")->first()->description;

        //jib tous les products dyal had l category, li titre dyal smitha $title
        //o 9asmhom 3la 12, pour la pagination
        $products = Category::where('title', 'like', "%$title%")->first()->products()->paginate(12);

        //afficher lview li kayna fi /resources/views/products/index.blade.php 
        //osift lya m3aha les variables 'products', 'title', 'description'
        return view('products.index', compact(['products', 'title', 'description']));
    }
}
