<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryManagerController extends Controller
{
    //page admin
    //route GET /categorymanager
    public function index()
    {
        //jib les derniers 5 categories
        $categories = Category::latest()->paginate(5);

        //afficher lview li kayna fi /resources/views/categorymanager/index.blade.php 
        //osift lya m3aha les variables 'categories'
        return view('categorymanager.index', compact('categories'));
    }



    //route GET /categorymanager/create
    public function create()
    {
        //afficher lview li kayna fi /resources/views/categorymanager/create.blade.php 
        return view('categorymanager.create');
    }



    //route POST /categorymanager
    public function store(Request $request)
    {
        //validation des champs
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //creer la category
        Category::create(array_merge($request->all()));

        //redirect la route 'GET /categorymanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('categorymanager.index')
            ->with('success', 'Category has been added successfully.');
    }



    //route GET /categorymanager/{id}
    public function edit($id)
    {
        //jib l category li ID = $id
        //sinon firstOrFail = 404
        $category = Category::where('id', $id)->firstOrFail();

        //afficher lview li kayna fi /resources/views/categorymanager/edit.blade.php 
        //osift lya m3aha les variables 'category'
        return view('categorymanager.edit', compact('category'));
    }

    //route PUT /productmanager/{id}
    public function update(Request $request, $id)
    {

        $category = Category::where('id', $id)->firstOrFail();

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        //update la category
        $category->update(array_merge($request->all()));

        //redirect la route 'GET /categorymanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('categorymanager.index')
            ->with('success', 'Category has been updated successfully.');
    }

    //route DELETE /categorymanager/{id}
    public function destroy($id)
    {
        //jib l category li ID = $id
        //sinon firstOrFail = 404
        $category = Category::where('id', $id)->firstOrFail();

        //delete the category

        $category->delete();
        //redirect la route 'GET /categorymanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('categorymanager.index')
            ->with('success', 'category has been deleted successfully.');
    }
}
