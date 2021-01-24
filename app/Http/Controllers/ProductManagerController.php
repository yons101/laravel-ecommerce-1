<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductManagerController extends Controller
{
    //page admin
    //route GET /productmanager
    public function index()
    {
        //jib les derniers 5 products
        $products = Product::latest()->paginate(5);

        //afficher lview li kayna fi /resources/views/productmanager/index.blade.php 
        //osift lya m3aha les variables 'products'
        return view('productmanager.index', compact('products'));
    }

    //route GET /productmanager/create
    public function create()
    {
        //jib les titre dyal tous les categories
        $categories = Category::all();

        //afficher lview li kayna fi /resources/views/productmanager/create.blade.php 
        return view('productmanager.create', compact('categories'));
    }


    //route POST /productmanager
    public function store(Request $request)
    {
        //validation des champs
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //9ad slug, aw url b had la methode
        //chaque espace f nom remplacih b -
        //bach n evitiw urls ikon mtchabhim
        //f lekher kanzid  time(), bach ikon unique
        $slug = Str::replaceArray(' ', ['-'], $request->title) .  '-'  . time();


        //nafs lblan pour le nom d'image
        $imageName = $request->title . '-'  . time()  . '.' .  $request->image->getClientOriginalExtension();

        //kan placiw l'image f dossier /public/img
        $request->image->move(public_path('img'), $imageName);

        //jib le chemin dyal image
        $path = '/img/' . $imageName;


        //creer lproduct
        Product::create(array_merge($request->all(), ['slug' => $slug, 'image' => $path]));

        //redirect la route 'GET /productmanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('productmanager.index')
            ->with('success', 'Product has been added successfully.');
    }


    //route GET /productmanager/{id}
    public function edit($id)
    {
        //jib l product li ID = $id
        //sinon firstOrFail = 404
        $product = Product::where('id', $id)->firstOrFail();

        //afficher lview li kayna fi /resources/views/productmanager/edit.blade.php 
        //osift lya m3aha les variables 'product'

        return view('productmanager.edit', compact('product'));
    }

    //route PUT /productmanager/{id}
    public function update(Request $request, $id)
    {
        //jib l product li ID = $id
        //sinon firstOrFail = 404
        $product = Product::where('id', $id)->firstOrFail();

        //validation des champs
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);


        //9ad slug, aw url b had la methode
        //chaque espace f nom remplacih b -
        //bach n evitiw urls ikon mtchabhim
        //f lekher kanzid  time(), la
        $slug = Str::replaceArray(' ', ['-'], $request->title) .  '-'  . time();

        //nafs lblan pour le nom d'image
        $imageName = $request->title . '-'  . time()  . '.' . $request->image->getClientOriginalExtension();

        //kan placiw l'image f dossier /public/img
        $request->image->move(public_path('img'), $imageName);

        //jib le chemin dyal image
        $path = '/img/' . $imageName;

        //update lproduct
        $product->update(array_merge($request->all(), ['slug' => $slug, 'image' => $path]));

        //redirect la route 'GET /productmanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('productmanager.index')
            ->with('success', 'Product has been updated successfully.');
    }


    //route DELETE /productmanager/{id}
    public function destroy($id)
    {
        //jib l product li ID = $id
        //sinon firstOrFail = 404
        $product = Product::where('id', $id)->firstOrFail();

        //delete the product
        $product->delete();

        //redirect la route 'GET /productmanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('productmanager.index')
            ->with('success', 'Product has been deleted successfully.');
    }
}
