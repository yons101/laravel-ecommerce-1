<?php

namespace App\Http\Controllers;

use App\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Symfony\Component\HttpFoundation\Session\Session;

class CheckoutController extends Controller
{

    public function index()
    {
        $products = Auth::user()->cart->products()->get()->groupBy('id');
        $totalPrice = Auth::user()->cart->products()->sum('price');

        // dd($products, $totalPrice);
        $lastId = 0;

        return view('checkout', compact(['lastId', 'products', 'totalPrice']));
    }


    public function store(Request $request)
    {
        // dd($request->request);

        $validator = Validator::make($request->all(), []);
        $input = $request->all();

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

        $this->validate($request, $validation);
        $stripe = Stripe::make('sk_test_gKIw0KKS2QV9SPkYvPUoHURc00dTwu0tos');
        try {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number'    => $request->get('card_no'),
                    'exp_month' => $request->get('exp_month'),
                    'exp_year'  => $request->get('exp_year'),
                    'cvc'       => $request->get('cvv'),
                ],
            ]);

            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount'   => $request->amount,
                'description' => 'Add in wallet',
                'metadata' => [
                    'name' => $request->name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'province' => $request->province,
                    'zip' => $request->zip,
                    'phone' => $request->phone,
                    'country' => $request->country,
                ],
            ]);
            if ($charge['status'] == 'succeeded') {
                return redirect()->route('thank-you', compact([]))->with('success', 'Your order has been successfully placed!');
            } else {
                return redirect()->route('checkout.index')->with('error', 'Your order has been declined!');
            }
        } catch (Exception $e) {
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        }
    }
}
