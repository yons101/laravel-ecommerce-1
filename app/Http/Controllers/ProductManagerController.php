<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::latest()->paginate(5);

        return view('productmanager.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productmanager.create');
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

        Product::create(array_merge($request->all(), ['slug' => $slug, 'image' => $path]));

        return redirect()->route('productmanager.index')
            ->with('success', 'Product has been added successfully.');
    }




    public function edit($id)
    {

        $product = Product::where('id', $id)->firstOrFail();

        return view('productmanager.edit', compact('product'));
    }


    public function update(Request $request, $id)
    {

        $product = Product::where('id', $id)->firstOrFail();

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

        $product->update(array_merge($request->all(), ['slug' => $slug, 'image' => $path]));

        return redirect()->route('productmanager.index')
            ->with('success', 'Product has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->firstOrFail();

        $product->delete();
        return redirect()->route('productmanager.index')
            ->with('success', 'Product has been deleted successfully.');
    }
}
