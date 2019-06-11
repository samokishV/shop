<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use DB;
use Illuminate\Contracts\View\Factory as Factory;
use Illuminate\View\View as View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category as Category;
use App\Product as Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $data['categories'] = Category::firstLevelCategories();
        $data['names'] = Category::getCategoriesName();
        $data['promo'] = Product::findPromo();

        $categories = Category::all();
        $data['menu'] = Category::buildMenu($categories, 0);

        foreach ($data['categories'] as $cat) {
            $data['sub-menu'][$cat->id] = Category::buildMenu($categories, $cat->id);
        }

        return view('index', compact("data"));
    }

    /**
     * @return Factory| View
     */
    public function adminIndex()
    {
        return view('admin-index', compact("data"));
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
        if (!isset($order)) {
            $order = 'default';
        }

        $price = $request->input('price');

        $category = Category::where('slug', $catSlug)->get();
        $catId =  $category[0]->id;

        $cat = Category::select('id', 'category', 'parent_id', 'slug')->get();
        $d = $cat->keyBy('id')->toArray();
        $tree = Category::buildTree($d);
        $ids = Category::getSubIds($tree, $catId);

        $products = Product::findByCategory($ids, $order, $price);

        return view('category', ['products'=>$products]);
    }

    /**
     * @param Request $request
     * @return Factory| View
     */
    public function cart(Request $request)
    {
        $userId = Auth::id();
        $products = Cart::getByUserId($userId);

        if (!$userId) {
            $cart = Session::get("cart");
            if ($cart) {
                $products = Cart::guestIndex($cart);
            }
        }

        return view('cart', ['products'=>$products]);
    }

    /**
     * @param Request $request
     * @return Factory| View
     */
    public function order(Request $request)
    {
        $request->flash();
        $userId = Auth::id();
        $cart = Cart::getByUserId($userId);

        if (!$userId) {
            $cart = Session::get("cart");
            if ($cart) {
                $cart = Cart::guestIndex($cart);
            }
        }

        return view('order', ['cart'=>$cart]);
    }
}
