<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('users')
            ->join('orders', 'users.id', 'orders.user_id')
            ->join('order_product', 'orders.id', 'order_product.order_id')
            ->join('products', 'products.id',  'order_product.product_id')
            ->where('users.id',  Auth::user()->id)
            ->select(
                'orders.id',
                'orders.is_shipped',
                DB::raw('SUM(products.price * order_product.quantity) as price')
            )
            ->groupBy(
                'orders.id',
                'orders.is_shipped',
            )
            ->paginate(5);


        $i = 0;
        return view('orders.index', compact(['orders', 'i']))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {

        $order = Order::create(['user_id' => $request->user_id]);

        $products = DB::table('users')
            ->join('carts', 'users.id', 'carts.user_id')
            ->join('products', 'products.id', 'carts.product_id')
            ->where('users.id',  Auth::user()->id)
            ->select(
                'products.id',
                'products.title',
                'products.slug',
                'products.price',
                'products.image',
                'carts.quantity',
                DB::raw('(products.price * carts.quantity) as price')
            )
            ->groupBy(
                'products.id',
                'products.title',
                'products.slug',
                'products.price',
                'products.image',
                'carts.quantity'
            )
            ->get();

        foreach ($products as $product) {
            DB::table('order_product')->insert([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $product->quantity,
            ]);
        }


        // $products = Auth::user()->cart->products()->get()->groupBy('id');
        $orders = Auth::user()->orders()->latest()->paginate(5);
        $i = 0;


        DB::table('carts')
            ->where('user_id', Auth::user()->id)
            ->delete();

        return view('orders.index', compact(['orders', 'i']))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function show($id)
    {
        $products = Order::findOrFail($id)->products()->latest()->paginate(5);
        $i = 0;
        return view('orders.show', compact(['products', 'i', 'id']))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
