<?php

namespace App\Http\Controllers;

use App\Order;
use Exception;
use App\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Symfony\Component\HttpFoundation\Session\Session;

class CheckoutController extends Controller
{

    //route GET /checkout
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

        //afficher lview li kayna fi /resources/views/checkout.blade.php 
        //osift lya m3aha les variables 'products', 'info'
        return view('checkout', compact(['products', 'info']));
    }


    //route POST /checkout
    public function store(Request $request)
    {
        //hna kansta3mlo service dtal stripe.com
        //bach n collectiw $$$


        //validation, tous les chanps sont obligatoire
        $validation = [
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvv' => 'required',
            'amount' => 'required',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zip' => 'required',
            'phone' => 'required',
            'country' => 'required',
        ];

        //methode pour valider
        $this->validate($request, $validation);

        //lkey dyal stripe, bach t3rf lmen tsift $$$
        $stripe = Stripe::make('sk_test_gKIw0KKS2QV9SPkYvPUoHURc00dTwu0tos');
        try {

            //token
            $token = $stripe->tokens()->create([
                'card' => [
                    'number'    => $request->get('card_no'),
                    'exp_month' => $request->get('exp_month'),
                    'exp_year'  => $request->get('exp_year'),
                    'cvc'       => $request->get('cvv'),
                ],
            ]);

            //kanjm3o les infos li dkhel lclient
            $data = [
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'zip' => $request->zip,
                'phone' => $request->phone,
                'country' => $request->country
            ];

            //stripe, katakhed $$$ mec la carte dyal lclient
            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount'   => $request->amount,
                'description' => 'Add in wallet',
                'metadata' => $data,
            ]);

            //fi halat naja7
            if ($charge['status'] == 'succeeded') {

                //redirect la route 'thank-you'
                //m3a wahd lmessage temporaire smito 'success'
                //et $data dyal lclient
                return redirect()->route('thank-you')->with([
                    'success' => 'Your order has been successfully placed!',
                    'data' => $data,
                ]);
            }
            //fi halat lfachal
            else {
                //redirect la route 'thank-you'
                //m3a wahd lmessage temporaire smito 'error'
                return redirect()->route('checkout.index')->with('error', 'Your order has been declined!');
            }
        }

        //gestion des Exceptions
        catch (Exception $e) {
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        }
    }
}
