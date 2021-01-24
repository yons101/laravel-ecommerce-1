<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    //la page pricipale
    //route GET /
    public function index()
    {

        //jib li 8 dyal les produits, par order aleatoire
        $products = Product::inRandomOrder()->take(8)->get();

        //afficher lview li kayna fi /resources/views/index.blade.php 
        //osift lya m3aha les variables 'products'
        return view('index', compact('products'));
    }
}
