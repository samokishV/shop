<?php

namespace App\Http\Controllers;

use App\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
