<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        if (Auth::user()->role == "admin") {
            return redirect()->route('productmanager.index');
        }
   
        
        $products = Auth::user()->cart->products->groupBy('id');

        $totalPrice = Auth::user()->cart->products()->sum('price');

        $lastId = 0;

        return view('cart', compact(['lastId', 'products', 'totalPrice']));
    }




    public function store(Request $request)
    {


        $product = Product::find($request->id);
        Auth::user()->cart->products()->attach($product);

        return redirect()->route('cart.index')->with('success', 'Item Was Added To Your Cart');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($request->id);

        $qtyInDB = Auth::user()->cart->products()->where('product_id', $product->id)->count();
        $requestedQty = $request->qty;

        $x = $qtyInDB - $requestedQty;


        if ($x >= 1) {
            //ex : qtyInDB 4 and $requestedQty 2 => this query will run 2 times
            DB::delete('delete from cart_product where product_id = ? order by id desc limit ?', [$product->id, $x]);
        } else if ($x < 0) {

            //ex : nqtyInDB 2 and $requestedQty 4 => this query will run 2 times

            for ($i = 0; $i < abs($x); $i++) {
                Auth::user()->cart->products()->attach($product);
            }
        } else if ($requestedQty == 0) {
            Auth::user()->cart->products()->detach($product);
        }

        // dd($requestedQty);

        // Auth::user()->cart->products()->detach($product);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $rowId
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        $product = Product::find($rowId);
        Auth::user()->cart->products()->detach($product);
        return redirect()->route('cart.index')->with('success', 'The Item Has Been Removed From Your Cart!');
    }

    //Empty the cart
    public function empty()
    {
        Auth::user()->cart->products()->detach();
        return redirect()->route('cart.index')->with('success', 'Your Cart Has Been Emptied!');
    }
}
