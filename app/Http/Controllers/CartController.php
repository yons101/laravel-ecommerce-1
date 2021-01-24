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

    //sauf l' users li mconectyin 
    //li 3ndhom le droit ysta3mlo had les methodes li f CartController
    public function __construct()
    {
        $this->middleware('auth');
    }

    //route GET /cart
    public function index()
    {
        //jib li lproducts li f la panier
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

        //jib li quantity dyal chaque produit
        //jib li total dyal ga3 les produits
        $info =  DB::table('users')
            ->join('carts', 'users.id', 'carts.user_id')
            ->join('products', 'products.id', 'carts.product_id')
            ->where('users.id', Auth::user()->id)
            ->select(DB::raw('SUM(carts.quantity) as quantity, SUM(products.price * carts.quantity) as totalPrice'))
            ->get();


        //la kan luser admin
        //matbynch lih la panier, hit hwa makaychrich
        //dir lih redirect l route /productmanager
        if (Auth::user()->role == "admin") {
            return redirect()->route('productmanager.index');
        }

        //afficher lview li kayna fi /resources/views/cart.blade.php 
        //osift lya m3aha les variables 'products', 'info'
        return view('cart', compact(['products', 'info']));
    }



    //route POST /cart
    public function store(Request $request)
    {
        //jib l ID dyal lproduct li rat ajouter LA KAN DEJA f panier
        $product_id = DB::table('carts')
            ->where('product_id', $request->id)
            ->get();

        //fi halat makanch deja f panier
        //kan creayiw enregistrement 3adi
        if ($product_id->isEmpty()) {
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->id,
                'quantity' => 1,
            ]);
        }
        //sinon ghi kandiro update l quantity
        else {
            DB::table('carts')
                ->where('user_id', Auth::user()->id)
                ->where('product_id', $request->id)
                ->update([
                    'quantity' => DB::raw('quantity + 1'),
                ]);
        }

        //redirect la route 'GET /cart', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('cart.index')->with('success', 'Item Was Added To Your Cart');
    }

    //route PUT /cart/{id}
    public function update(Request $request, $id)
    {
        //la kant quantity < 0
        //redirect la route 'GET /cart', m3a wahd lmessage temporaire smito 'error'
        if ($request->qty < 0) {
            return redirect()->route('cart.index')->with('error', 'Choose a postive value');
        }
        //la kant quantity = 0
        //supprimer lproduct men la panier
        //redirect la route 'GET /cart', m3a wahd lmessage temporaire smito 'success'
        else if ($request->qty == 0) {
            DB::table('carts')
                ->where('product_id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->delete();
            return redirect()->route('cart.index')->with('success', 'Item has been removed from your cart');
        }
        //la kant quantity > 0
        //update l quantity dyal lproduct
        //redirect la route 'GET /cart', m3a wahd lmessage temporaire smito 'success'
        else {
            DB::table('carts')
                ->where('user_id', Auth::user()->id)
                ->where('product_id', $request->id)
                ->update([
                    'quantity' => $request->qty
                ]);
            return redirect()->route('cart.index')->with('success', 'Item quantity has been updated');
        }
    }

    //route DELETE /cart/{id}
    public function destroy($rowId)
    {
        //supprimer lproduct li id = $rowId
        DB::table('carts')
            ->where('product_id', $rowId)
            ->where('user_id', Auth::user()->id)
            ->delete();

        //redirect la route 'GET /cart', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('cart.index')->with('success', 'The Item Has Been Removed From Your Cart!');
    }

    //route POST /cart/empty
    public function empty()
    {
        //supprimer tous les produits men la panier
        DB::table('carts')
            ->where('user_id', Auth::user()->id)
            ->delete();

        //redirect la route 'GET /cart', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('cart.index')->with('success', 'Your Cart Has Been Emptied!');
    }
}
