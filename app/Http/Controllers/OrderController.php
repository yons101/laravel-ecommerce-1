<?php

namespace App\Http\Controllers;

use App\Order;
use App\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //route GET /orders
    public function index()
    {
        //jib tous les orders dyal lclient
        $orders = $this->getOrders();

        //afficher lview li kayna fi /resources/views/orders/index.blade.php 
        //osift lya m3aha les variables 'orders'
        return view('orders.index', compact(['orders']));
    }

    //route POST /orders
    public function store(Request $request)
    {

        //creer lorder, b ID dyal lclient
        $order = Order::create(['user_id' => Auth::user()->id]);


        //jib li lproducts li f la panier o7thom f $products
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


        //pour chaque product, radi ndiro lo association m3a l'order
        //c-a-d les combinaisons dyal order/product
        //par ex:
        //order 101, product : 299, quantity : 2
        //order 101, product : 300, quantity : 1
        //order 101, product : 301, quantity : 4
        foreach ($products as $product) {
            DB::table('order_product')->insert([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $product->quantity,
            ]);
        }

        //creer shipping, fin ratwsl sl3a lclient
        Shipping::create([
            'order_id' => $order->id,
            'fullname' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->zip,
            'phone' => $request->phone,
            'country' => $request->country
        ]);

        //jib tous les orders dyal lclient
        $orders = $this->getOrders();


        //men ba3d ma dazt la commande, kankhwiw la panier
        DB::table('carts')
            ->where('user_id', Auth::user()->id)
            ->delete();

        //afficher lview li kayna fi /resources/views/orders/index.blade.php 
        //osift lya m3aha les variables 'orders'
        return view('orders.index', compact(['orders']));
    }


    //route GET /orders/{id}
    public function show($id)
    {
        //jib tous les products li kayntamiw l nafs lorder
        //c-a-d afficher le contenu dyal lorder
        //pagination par 5
        $products = Order::findOrFail($id)->products()->latest()->paginate(5);

        //afficher lview li kayna fi /resources/views/orders/show.blade.php 
        //osift lya m3aha les variables 'products'
        return view('orders.show', compact(['products']));
    }


    //methode kat retourner tous les orders dyal lclient, et wach t shippaw
    //pagination par 5
    public function getOrders()
    {
        $orders = DB::table('users')
            ->join('orders', 'users.id', 'orders.user_id')
            ->join('order_product', 'orders.id', 'order_product.order_id')
            ->join('products', 'products.id',  'order_product.product_id')
            ->join('shippings', 'orders.id',  'shippings.order_id')
            ->where('users.id',  Auth::user()->id)
            ->select(
                'orders.id',
                'shippings.is_shipped',
                DB::raw('SUM(products.price * order_product.quantity) as price')
            )
            ->groupBy(
                'orders.id',
                'shippings.is_shipped',
            )
            ->paginate(5);

        return $orders;
    }
}
