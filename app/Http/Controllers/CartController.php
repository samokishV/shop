<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function add(Request $request)
    {
        $productId= $request->input('id');
        $qt= $request->input('qt');

        $userId = Auth::id();

        if (!$userId) {
            $cart = Session::get('cart');
            $product = Cart::findInCart($productId, $cart);

            if (!$product) {
                $products = Cart::addToCart($productId, $qt, $cart);
                Session::put('cart', $products);
                return "Product successfully add to cart";
            } else {
                return "product already in cart";
            }
        } else {
            $product = Cart::findById($userId, $productId);

            if ($product) {
                return "product already in cart";
            } else {
                Cart::add($userId, $productId, $qt);
                return "Product successfully add to cart";
            }
        }
    }

    /**
     * @param Request $request
     * @param $productId
     * @return int
     */
    public function delete(Request $request, $productId)
    {
        $userId = Auth::id();
        $result = Cart::deleteById($userId, $productId);

        if (!$userId) {
            $cart = Session::get('cart');
            $result = Cart::deleteFromCart($cart, $productId);
        }

        return $result;
    }

    /**
     * @return int
     */
    public function deleteAll()
    {
        $userId = Auth::id();
        $result = Cart::deleteAll($userId);

        if (!$userId) {
            Session::forget('cart');
        }

        return $result;
    }

    /**
     * @param Request $request
     * @param string $productId
     */
    public function update(Request $request, $productId)
    {
        $userId = Auth::id();
        $qt= $request->qt;

        if (!$userId) {
            $cart = Session::get('cart');
            Cart::updateCart($cart, $productId, $qt);
        } else {
            Cart::updateById($userId, $productId, $qt);
        }
    }
}
