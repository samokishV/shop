<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
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

        if($product) {
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
        return view('products.index', ['products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function updatePromo(Request $request, $id)
    {
        $status = $request['promo'];

        if($status=="on") {
            $status = 1;
        } else {
            $status = 0;
        }

        Product::changeStatus($id, $status);

        return redirect('admin/product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.add', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'category' => 'required | numeric',
            'slug' => ['required', 'alpha_dash', Rule::unique('products')],
            'image' => ['required', Rule::dimensions()->minWidth(400)->minHeight(400)],
            'image.*' => 'mimes:jpeg,png,jpg | max:2048',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required | numeric',
            'in_stock' => 'required | numeric'
        ]);

        if ($validator->fails()) {
            $request->flash();
            $categories = Category::all();
            return view('products.add', ['categories' => $categories])->withErrors($validator->messages());
        } else {
            $categoryId = $request['category'];
            $info = $request->only('title', 'slug', 'description', 'price', 'in_stock', 'additional');
            $info["image"] = $request->file("image");
            $status = $request['promo'];

            if($status=="on") {
                $promo = 1;
            } else {
                $promo = 0;
            }
            Product::store($categoryId, $info, $promo);
            return redirect('admin/product');
        }
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
        return view('products.edit', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator =  Validator::make($request->all(), [
            'category' => 'required | numeric',
            'slug' => ['required', 'alpha_dash', Rule::unique('products')->ignore($id)],
            'image' => [Rule::dimensions()->minWidth(400)->minHeight(400)],
            'image.*' => 'mimes:jpeg,png,jpg | max:2048',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required | numeric',
            'in_stock' => 'required | numeric'
        ]);

        if ($validator->fails()) {
            $request->flash();
            $products = Product::findById($id);
            $categories = Category::all();
            return view('products.edit', ['categories' => $categories, 'products' => $products])->withErrors($validator->messages());
        } else {
            $categoryId = $request['category'];
            $info = $request->only('title', 'slug', 'description', 'price', 'in_stock', 'additional');
            $info["image"] = $request->file("image");
            $status = $request['promo'];

            if($status=="on") {
                $promo = 1;
            } else {
                $promo = 0;
            }
            Product::updateById($id, $categoryId, $info, $promo);
            return redirect('admin/product');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
    }
}
