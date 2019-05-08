<?php

namespace App\Http\Controllers;

use App\Cart;
use DB;
use Illuminate\Contracts\View\Factory as Factory;
use Illuminate\View\View as View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category as Category;
use App\Product as Product;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @param Request $request
     * @return Factory| View
     */
    public function cart(Request $request)
    {
        $userId = Auth::id();

        $products = Cart::index($userId);

        return view('cart', ['products'=>$products]);
    }
}

