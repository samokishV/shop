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
}