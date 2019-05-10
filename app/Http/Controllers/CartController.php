<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(!$userId) {
            return "You should be registered to add product to cart!";
        }

        $product = Cart::findById($userId, $productId);

        if($product) {
            return "product already in cart";
        } else {
            Cart::add($userId, $productId, $qt);
            return "Product successfully add to cart";
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
        return $result;
    }

    /**
     * @return int
     */
    public function deleteAll()
    {
        $userId = Auth::id();

        $result = Cart::deleteAll($userId);
        return $result;
    }

    /**
     * @param string $productId
     * @return void
     */
    public function update(Request $request, $productId)
    {
        $userId = Auth::id();
        $qt= $request->qt;

        $result = Cart::updateById($userId, $productId, $qt);
        return $result;
    }
}