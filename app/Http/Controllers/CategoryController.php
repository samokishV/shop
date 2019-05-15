<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'category' => 'required | unique:"categories',
            'slug' => 'required | alpha_dash | unique:"categories',
            'image' => ['required',
                Rule::dimensions()->minWidth(400)->minHeight(400)
            ],
            'image.*' => 'mimes:jpeg,png,jpg | max:2048'
        ]);

        if ($validator->fails()) {
            $request->flash();
            return view('categories.add')->withErrors($validator->messages());
        } else {
            $category = $request["category"];
            $slug = $request["slug"];
            $image = $request->file("image");
            Category::store($category, $slug, $image);
            return redirect('admin/category');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', ["category" => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator =  Validator::make($request->all(), [
            'category' => ['required', Rule::unique('categories')->ignore($id)],
            'slug' => ['required', 'alpha_dash', Rule::unique('categories')->ignore($id)],
            'image' => [Rule::dimensions()->minWidth(400)->minHeight(400)],
            'image.*' => 'mimes:jpeg,png,jpg | max:2048'
        ]);

        if ($validator->fails()) {
            $request->flash();
            $category = Category::find($id);
            return view('categories.edit', ["category" => $category])->withErrors($validator->messages());
        } else {
            $category = $request["category"];
            $slug = $request["slug"];
            $image = $request->file("image");
            Category::updateById($id, $category, $slug, $image);
            return redirect('admin/category');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::deleteById($id);
    }
}
