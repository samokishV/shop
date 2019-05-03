<?php

namespace App\Http\Controllers;

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
        $product = DB::select('select * from products where slug = ?', [$slug]);
        if(isset($product[0])) {
            return view('product', ['products' => $product, 'title' => $product[0]->title]);
        }
        else {
            return response('Page not found', 404);
        }
    }
}
