<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $products = Product::inRandomOrder()->take(8)->get();
        return view('index', compact('products'));
    }
}
