<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($title)
    {
        $description = Category::where('title', 'like', "%$title%")->first()->description;

        $products = Category::where('title', 'like', "%$title%")->first()->products()->paginate(12);

        return view('products.index', compact(['products', 'title', 'description']))->with((request()->input('page', 1) - 1) * 12);
    }
}
