<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use App\Services\CategoryService;
use Illuminate\Http\Response;
use Validator;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoryService $category
     * @return Response
     */
    public function index(CategoryService $category)
    {
        $categories = Category::all();
        $categoriesNames = $category::getCategoriesName();
        return view('categories.index', ['categories' => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CategoryService $category
     * @return Response
     */
    public function create(CategoryService $category)
    {
        $categories = Category::all();
        $categoriesNames = $category::getCategoriesName();
        return view('categories.add', ['categories' => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategory $request
     * @param CategoryService $category
     * @return Response
     */
    public function store(StoreCategory $request, CategoryService $category)
    {
        $parentCategory = $request["parent_category"];
        $categoryTitle = $request["category"];
        $slug = $request["slug"];
        $image = $request->file("image");

        $category->store($parentCategory, $categoryTitle, $slug, $image);
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
     * @param int $id
     * @param CategoryService $category
     * @return Response
     */
    public function edit($id, CategoryService $category)
    {
        $categories = Category::all();
        $categoriesNames = $category::getCategoriesName();
        $category = Category::find($id);

        return view('categories.edit', ["category" => $category, "categories" => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategory $request
     * @param int $id
     * @param CategoryService $category
     * @return Response
     */
    public function update(UpdateCategory $request, $id, CategoryService $category)
    {
        $parentCategory = $request["parent_category"];
        $categoryTitle = $request["category"];
        $slug = $request["slug"];
        $image = $request->file("image");

        $category->update($parentCategory, $categoryTitle, $slug, $image, $id);
        return redirect(route('admin.category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param CategoryService $category
     * @return void
     */
    public function destroy($id, CategoryService $category)
    {
        $category->destroy($id);
    }
}
