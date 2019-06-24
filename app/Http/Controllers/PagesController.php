<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CategoryService;
use DB;
use Illuminate\Contracts\View\Factory as Factory;
use Illuminate\View\View as View;
use Illuminate\Http\Request;
use App\Category as Category;
use App\Product as Product;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Display the home page.
     *
     * @param CategoryService $category
     * @return Factory| View
     */
    public function index(CategoryService $category)
    {
        $data = [];
        $data['categories'] = Category::firstLevelCategories();
        $data['names'] = $category::getCategoriesName();
        $data['promo'] = Product::findPromo();

        $categories = Category::all();
        $data['menu'] = $category::buildMenu($categories, 0);

        foreach ($data['categories'] as $cat) {
            $data['sub-menu'][$cat->id] = $category::buildMenu($categories, $cat->id);
        }

        return view('index', compact("data"));
    }

    /**
     * @return Factory| View
     */
    public function adminIndex()
    {
        return view('admin-index');
    }

    /**
     * Display the category page.
     *
     * @param Request $request
     * @param $catSlug
     * @param CategoryService $category
     * @return Factory | View
     */
    public function category(Request $request, $catSlug, CategoryService $category)
    {
        $request->flash();
        $order = $request->input('sort-options');
        $price = $request->input('price');

        $products = $category->getProducts($order, $price, $catSlug);

        return view('category', ['products'=>$products]);
    }

    /**
     * Display cart page.
     *
     * @param Request $request
     * @param CartService $cart
     * @return Factory| View
     */
    public function cart(Request $request, CartService $cart)
    {
        $userId = Auth::id();
        $products = $cart->getProducts($userId);

        return view('cart', ['products'=>$products]);
    }
}
