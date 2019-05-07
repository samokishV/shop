<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Contracts\View\Factory as Factory;
use Illuminate\Illuminate\View\View as View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category as Category;
use App\Product as Product;

class PagesController extends Controller
{
    /**
     * Display the home page.
     *
     * @return Factory| View
     */
    public function index()
    {
        $data = [];
        $data['categories'] = Category::all();
        $data['promo'] = Product::findPromo();

        return view('index', compact("data"));
    }

    /**
     * Display the category page.
     *
     * @param Request $request
     * @param $catSlug
     * @return Factory | View
     */
    public function category(Request $request, $catSlug)
    {
        $request->flash();

        $order = $request->input('sort-options');
        if(!isset($order)) $order = 'default';

        $price = $request->input('price');

        $products = Product::findByCategory($catSlug, $order, $price);

        return view('category', ['products'=>$products]);
    }
}

