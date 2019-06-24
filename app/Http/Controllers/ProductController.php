<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Validation\ValidationException;
use Validator;
use App\Product;
use App\Category;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $slug
     * @return Response
     */
    public function show(Request $request, $slug)
    {
        $product = Product::findBySlug($slug);

        if ($product) {
            return view('product', ['product' => $product, 'title' => $product->title]);
        } else {
            return response('Page not found', 404);
        }
    }

    /**
     * @param Request $request
     * @param ProductService $product
     * @return Factory|View
     * @throws ValidationException
     */
    public function search(Request $request, ProductService $product)
    {
        $this->validate($request, [
            'keyword' => 'required'
        ]);

        $keyword = $request['keyword'];
        $products = $product->search($keyword);
        return view('search', ['products' => $products]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param CategoryService $category
     * @return Response
     */
    public function index(CategoryService $category)
    {
        $products = Product::findAll();
        $categoriesNames = $category::getCategoriesName();
        return view('products.index', ['products' => $products, 'catFullName' => $categoriesNames]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @param ProductService $product
     * @return RedirectResponse|Redirector
     */
    public function updatePromo(Request $request, $id, ProductService $product)
    {
        $promo = $request['promo'];
        $product->updatePromo($promo, $id);
        return redirect(route('admin.product.index'));
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
        return view('products.add', ['categories' => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProduct $request
     * @param ProductService $product
     * @return Response
     */
    public function store(StoreProduct $request, ProductService $product)
    {
        $categoryId = $request['category'];
        $info = $request->only('title', 'slug', 'description', 'price', 'in_stock', 'additional');
        $image = $request->file("image");
        $status = $request['promo'];
        $additional = $request['additional'];

        $product->create($categoryId, $info, $image, $status, $additional);
        return redirect(route('admin.product.index'));
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
        $products = Product::findById($id);
        $categories = Category::all();
        $categoriesNames = $category::getCategoriesName();
        return view('products.edit', ['products' => $products, 'categories' => $categories, 'catFullName' => $categoriesNames]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProduct $request
     * @param int $id
     * @param ProductService $product
     * @return Response
     */
    public function update(UpdateProduct $request, $id, ProductService $product)
    {
        $categoryId = $request['category'];
        $info = $request->only('title', 'slug', 'description', 'price', 'in_stock', 'additional');
        $image = $request->file("image");
        $status = $request['promo'];
        $additional = $request['additional'];

        $product->update($categoryId, $info, $image, $status, $additional, $id);
        return redirect(route('admin.product.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param ProductService $product
     * @return void
     */
    public function destroy($id, ProductService $product)
    {
        $product->destroy($id);
    }
}
