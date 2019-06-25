<?php

namespace App\Services;

use App\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Add product in cart.
     *
     * @param int $productId
     * @param string $qt
     * @return string
     */
    public function addProduct($productId, $qt)
    {
        $cart = Session::get('cart');
        $product = self::findInCart($productId, $cart);

        if (!$product) {
            $products = self::addToCart($productId, $qt, $cart);
            Session::put('cart', $products);
            return "Product successfully add to cart";
        } else {
            return "product already in cart";
        }
    }

    /**
     * Update product qt in cart.
     *
     * @param int $productId
     * @param string $qt
     * @return bool|string
     */
    public function updateProduct($productId, $qt)
    {
        $cart = Session::get('cart');
        $result = self::updateCart($cart, $productId, $qt);

        return $result;
    }

    /**
     * Remove product from cart.
     *
     * @param int $productId
     * @return Collection|int
     */
    public function removeProduct($productId)
    {
        $cart = Session::get('cart');
        $result = self::deleteFromCart($cart, $productId);

        return $result;
    }

    /**
     * Delete all products from cart.
     *
     * @return void
     */
    public function clear()
    {
        Session::forget('cart');
    }

    /**
     * @return Collection|null
     */
    public function getProducts()
    {
        $cart = Session::get("cart");
        $cart = self::cartIndex($cart);

        return $cart;
    }

    /**
     * Get full info about product in cart.
     *
     * @param array $cart
     * @return Collection
     */
    public static function cartIndex($cart)
    {
        $cart = $cart->toArray();
        $keys = array_keys($cart);
        $products = Cart::getProducts($keys);

        foreach ($products as $product) {
            $product->qt = $cart[$product->id];
            $product->total = $product->qt*$product->price;
        }
        return $products;
    }

    /**
     * @return int
     */
    public static function getTotal()
    {
        $cart = Session::get("cart");
        $products = self::cartIndex($cart);

        $total = 0;
        foreach ($products as $product) {
            $total += $product->total;
        }

        return $total;
    }

    /**
     * Find if product exists in session cart array.
     *
     * @param string $productId
     * @param Collection $cart | [string => string] | [id1 => qt, id2 => qt]
     * @return string | null
     */
    public static function findInCart($productId, $cart)
    {
        if (isset($cart[$productId])) {
            return $cart[$productId];
        }
    }

    /**
     * Add product to cart array.
     *
     * @param string $productId
     * @param string $qt
     * @param Collection $cart | [string => string] | [id1 => qt, id2 => qt]
     * @return Collection
     */
    public static function addToCart($productId, $qt, $cart)
    {
        $cart[$productId] = $qt;
        $products = collect($cart);
        return $products;
    }

    /**
     * Update product qt in cart array.
     * @param Collection $cart | [string => string] | [id1 => qt, id2 => qt]
     * @param string $productId
     * @param string $qt
     * @return string
     */
    public static function updateCart($cart, $productId, $qt)
    {
        $cart[$productId] = $qt;
        $products = collect($cart);
        return $products;
    }

    /**
     * Delete product from cart array.
     *
     * @param Collection $cart | [string => string] | [id1 => qt, id2 => qt]
     * @param string $productId
     * @return Collection
     */
    public static function deleteFromCart($cart, $productId)
    {
        return $cart->forget($productId);
    }

    /**
     * Count products in cart array.
     *
     * @param Collection $cart | [string => string] | [id1 => qt, id2 => qt]
     * @return int
     */
    public static function countProducts($cart)
    {
        return count($cart);
    }
}
