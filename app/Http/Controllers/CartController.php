<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @param CartService $cart
     * @return string
     */
    public function add(Request $request, CartService $cart)
    {
        $productId= $request->input('id');
        $qt= $request->input('qt');

        $result =  $cart->addProduct($productId, $qt);
        if($result) {
            $message = "Product successfully add to cart";
        } else {
            $message = "Product already in cart";
        }
        return $message;
    }

    /**
     * @param $productId
     * @param CartService $cart
     * @return int
     */
    public function delete($productId, CartService $cart)
    {
        $result = $cart->removeProduct($productId);
        return $result;
    }

    /**
     * @param CartService $cart
     */
    public function deleteAll(CartService $cart)
    {
        $cart->clear();
    }

    /**
     * @param Request $request
     * @param string $productId
     * @param CartService $cart
     * @return mixed
     */
    public function update(Request $request, $productId, CartService $cart)
    {
        $qt = $request->qt;
        $result = $cart->updateProduct($productId, $qt);
        return $result;
    }
}
