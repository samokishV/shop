<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $userId = Auth::id();

        $result =  $cart->addProduct($productId, $qt, $userId);
        return $result;
    }

    /**
     * @param $productId
     * @param CartService $cart
     * @return int
     */
    public function delete($productId, CartService $cart)
    {
        $userId = Auth::id();
        $result = $cart->removeProduct($productId, $userId);
        return $result;
    }

    /**
     * @param CartService $cart
     * @return int
     */
    public function deleteAll(CartService $cart)
    {
        $userId = Auth::id();
        $result = $cart->clear($userId);
        return $result;
    }

    /**
     * @param Request $request
     * @param string $productId
     * @param CartService $cart
     * @return mixed
     */
    public function update(Request $request, $productId, CartService $cart)
    {
        $userId = Auth::id();
        $qt = $request->qt;
        $result = $cart->updateProduct($productId, $qt, $userId);
        return $result;
    }
}
