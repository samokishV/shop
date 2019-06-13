<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use Illuminate\Http\Response;
use Validator;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::all();
        $categoriesNames = Category::getCategoriesName();
        return view('categories.index', ['categories' => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        $categoriesNames = Category::getCategoriesName();
        return view('categories.add', ['categories' => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategory $request
     * @return Response
     */
    public function store(StoreCategory $request)
    {
        $parentCategory = $request["parent_category"];
        $category = $request["category"];
        $slug = $request["slug"];
        $image = $request->file("image");
        Category::store($parentCategory, $category, $slug, $image);
        return redirect(route('admin.category.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        $categoriesNames = Category::getCategoriesName();
        return view('categories.edit', ["category" => $category, "categories" => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategory $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateCategory $request, $id)
    {
        $parentCategory = $request["parent_category"];
        $category = $request["category"];
        $slug = $request["slug"];
        $image = $request->file("image");
        Category::updateById($id, $parentCategory, $category, $slug, $image);
        return redirect(route('admin.category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Category::deleteById($id);
    }
}
