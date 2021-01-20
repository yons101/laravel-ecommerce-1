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

        $info =  DB::table('users')
            ->join('carts', 'users.id', 'carts.user_id')
            ->join('products', 'products.id', 'carts.product_id')
            ->where('users.id', Auth::user()->id)
            ->select(DB::raw('SUM(carts.quantity) as quantity, SUM(products.price * carts.quantity) as totalPrice'))
            ->get();


        if (Auth::user()->role == "admin") {
            return redirect()->route('productmanager.index');
        }

        $lastId = 0;

        return view('cart', compact(['lastId', 'products', 'info']));
    }




    public function store(Request $request)
    {
        $product_id = DB::table('carts')
            ->where('product_id', $request->id)
            ->get();
        if ($product_id->isEmpty()) {
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->id,
                'quantity' => 1,
            ]);
        } else {
            DB::table('carts')
                ->where('user_id', Auth::user()->id)
                ->where('product_id', $request->id)
                ->update([
                    'quantity' => DB::raw('quantity + 1'),
                ]);
        }



        return redirect()->route('cart.index')->with('success', 'Item Was Added To Your Cart');
    }

    public function update(Request $request, $id)
    {

        if ($request->qty < 0) {
        } else if ($request->qty == 0) {
            DB::table('carts')
                ->where('product_id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->delete();
        } else {

            DB::table('carts')
                ->where('user_id', Auth::user()->id)
                ->where('product_id', $request->id)
                ->update([
                    'quantity' => $request->qty
                ]);
        }


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
        DB::table('carts')
            ->where('product_id', $rowId)
            ->where('user_id', Auth::user()->id)
            ->delete();

        return redirect()->route('cart.index')->with('success', 'The Item Has Been Removed From Your Cart!');
    }

    //Empty the cart
    public function empty()
    {
        DB::table('carts')
            ->where('user_id', Auth::user()->id)
            ->delete();
        return redirect()->route('cart.index')->with('success', 'Your Cart Has Been Emptied!');
    }
}
