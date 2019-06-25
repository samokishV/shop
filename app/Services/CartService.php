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
     * @return bool
     */
    public function addProduct($productId, $qt)
    {
        $product = self::findInCart($productId);

        if (!$product) {
            $products = self::addToCart($productId, $qt);
            Session::put('cart', $products);
            return true;
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
        $result = self::updateCart($productId, $qt);

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
        $result = self::deleteFromCart($productId);

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
        $cart = self::cartIndex();

        return $cart;
    }

    /**
     * Get full info about product in cart.
     *
     * @return Collection
     */
    public static function cartIndex()
    {
        $cart = Session::get("cart");

        if($cart) {
            $cart = $cart->toArray();
            $keys = array_keys($cart);
            $products = Cart::getProducts($keys);

            foreach ($products as $product) {
                $product->qt = $cart[$product->id];
                $product->total = $product->qt * $product->price;
            }
            return $products;
        }
    }

    /**
     * @return int
     */
    public static function getTotal()
    {
        $products = self::cartIndex();

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
     * @return string | null
     */
    public static function findInCart($productId)
    {
        $cart = Session::get("cart");

        if (isset($cart[$productId])) {
            return $cart[$productId];
        }
    }

    /**
     * Add product to cart array.
     *
     * @param string $productId
     * @param string $qt
     * @return Collection
     */
    public static function addToCart($productId, $qt)
    {
        $cart = Session::get('cart');

        $cart[$productId] = $qt;
        $products = collect($cart);
        return $products;
    }

    /**
     * Update product qt in cart array.
     *
     * @param string $productId
     * @param string $qt
     * @return string
     */
    public static function updateCart($productId, $qt)
    {
        $cart = Session::get('cart');

        $cart[$productId] = $qt;
        $products = collect($cart);
        return $products;
    }

    /**
     * Delete product from cart array.
     *
     * @param string $productId
     * @return Collection
     */
    public static function deleteFromCart($productId)
    {
        $cart = Session::get('cart');

        return $cart->forget($productId);
    }

    /**
     * Count products in cart array.
     *
     * @return int
     */
    public static function countProducts()
    {
        $cart = Session::get('cart');

        return count($cart);
    }

    /**
     * @return bool
     */
    public static function exists()
    {
        return Session::has('cart');
    }
}
