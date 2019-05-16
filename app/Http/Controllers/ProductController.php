<?php

namespace App\Http\Controllers;

use App\Product;
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
}
