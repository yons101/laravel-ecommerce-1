<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = Order::latest()->paginate(5);

        return view('ordermanager.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ordermanager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $slug = Str::replaceArray(' ', ['-'], $request->title) .  '-'  . time();

        $imageName = $request->title . '-'  . time()  . '.' . $request->image->getClientOriginalExtension();

        $request->image->move(public_path('img'), $imageName);

        $path = '/img/' . $imageName;

        Order::create(array_merge($request->all(), ['slug' => $slug, 'image' => $path]));

        return redirect()->route('ordermanager.index')
            ->with('success', 'Order has been added successfully.');
    }

    public function show($id)
    {

        $order = Order::where('id', $id)->firstOrFail();

        return view('ordermanager.show', compact('order'));
    }


    public function edit($id)
    {

        $order = Order::where('id', $id)->firstOrFail();

        return view('ordermanager.edit', compact('order'));
    }


    public function update(Request $request, $id)
    {

        // dd($request->is_shipped);
        $order = Order::where('id', $id)->firstOrFail();

        $order->is_shipped = $request->is_shipped;
        $order->save();

        return redirect()->route('ordermanager.index')
            ->with('success', 'Order has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)->firstOrFail();

        $order->delete();
        return redirect()->route('ordermanager.index')
            ->with('success', 'Order has been deleted successfully.');
    }
}
