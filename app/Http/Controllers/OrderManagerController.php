<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderManagerController extends Controller
{
    //page admin
    //route GET /ordermanager
    public function index()
    {
        //jib les derniers 5 Orders
        $orders = Order::latest()->paginate(5);

        //afficher lview li kayna fi /resources/views/ordermanager/index.blade.php 
        //osift lya m3aha les variables 'orders'
        return view('ordermanager.index', compact('orders'));
    }


    //route GET /ordermanager/{id}
    public function show($id)
    {
        //jib l Order li ID = $id
        //sinon firstOrFail = 404
        $order = Order::where('id', $id)->firstOrFail();


        //afficher lview li kayna fi /resources/views/ordermanager/show.blade.php 
        //osift lya m3aha les variables 'order'
        return view('ordermanager.show', compact('order'));
    }

    //route PUT /ordermanager/{id}
    public function update(Request $request, $id)
    {
        //jib l order li ID = $id
        //sinon firstOrFail = 404
        $order = Order::where('id', $id)->firstOrFail();

        //la siftna lproduct, ndiro is_shipped = true
        $order->shipping->is_shipped = $request->is_shipped;
        $order->shipping->save();

        //redirect la route 'GET /ordermanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('ordermanager.index')
            ->with('success', 'Order has been updated successfully.');
    }
}
