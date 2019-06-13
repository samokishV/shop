<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Services\ProductService;
use Validator;
use App\Product;
use App\Category;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
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
     * @return Factory|View
     * @throws ValidationException
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required'
        ]);

        $request->flash();

        $keyword = $request->input('keyword');
        $product = Product::searchByKeyword($keyword);

        return view('search', ['products' => $product]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::findAll();
        $categoriesNames = Category::getCategoriesName();
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
        $product->updatePromo($request, $id);
        return redirect(route('admin.product.index'));
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
        $product->create($request);
        return redirect(route('admin.product.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $products = Product::findById($id);
        $categories = Category::all();
        $categoriesNames = Category::getCategoriesName();
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
        $product->update($request, $id);
        return redirect(route('admin.product.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
    }
}
