<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::latest()->paginate(5);

        return view('categorymanager.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorymanager.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $slug = Str::replaceArray(' ', ['-'], $request->title) .  '-'  . time();

        $imageName = $request->title . '-'  . time()  . '.' . $request->image->getClientOriginalExtension();

        $request->image->move(public_path('img'), $imageName);

        $path = '/img/' . $imageName;

        Category::create(array_merge($request->all(), ['image' => $path]));

        return redirect()->route('categorymanager.index')
            ->with('success', 'Category has been added successfully.');
    }




    public function edit($id)
    {

        $category = Category::where('id', $id)->firstOrFail();

        return view('categorymanager.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {

        $category = Category::where('id', $id)->firstOrFail();

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

        $category->update(array_merge($request->all(), ['slug' => $slug, 'image' => $path]));

        return redirect()->route('categorymanager.index')
            ->with('success', 'Category has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id', $id)->firstOrFail();

        $category->delete();
        return redirect()->route('categorymanager.index')
            ->with('success', 'category has been deleted successfully.');
    }
}
