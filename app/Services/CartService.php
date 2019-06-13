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
     * @param int $userId
     * @return string
     */
    public function addProduct($productId, $qt, $userId)
    {
        if (!$userId) {
            $cart = Session::get('cart');
            $product = self::findInCart($productId, $cart);

            if (!$product) {
                $products = self::addToCart($productId, $qt, $cart);
                Session::put('cart', $products);
                return "Product successfully add to cart";
            } else {
                return "product already in cart";
            }
        } else {
            $product = Cart::findProductById($userId, $productId);

            if ($product) {
                return "product already in cart";
            } else {
                Cart::add($userId, $productId, $qt);
                return "Product successfully add to cart";
            }
        }
    }

    /**
     * Update product qt in cart.
     *
     * @param int $productId
     * @param string $qt
     * @param int $userId
     * @return bool|string
     */
    public function updateProduct($productId, $qt, $userId)
    {
        if (!$userId) {
            $cart = Session::get('cart');
            $result = self::updateCart($cart, $productId, $qt);
        } else {
            $result = Cart::updateById($userId, $productId, $qt);
        }

        return $result;
    }

    /**
     * Remove product from cart.
     *
     * @param int $productId
     * @param int $userId
     * @return Collection|int
     */
    public function removeProduct($productId, $userId)
    {
        $result = Cart::deleteProductById($userId, $productId);

        if (!$userId) {
            $cart = Session::get('cart');
            $result = self::deleteFromCart($cart, $productId);
        }

        return $result;
    }

    /**
     * Delete all products from cart.
     *
     * @param int $userId
     * @return int
     */
    public function clear($userId)
    {
        $result = Cart::deleteAll($userId);

        if (!$userId) {
            Session::forget('cart');
        }

        return $result;
    }

    /**
     * @param int $userId
     * @return Collection|mixed
     */
    public function getProducts($userId)
    {
        $cart = Cart::getByUserId($userId);

        if (!$userId) {
            $cart = Session::get("cart");
            if ($cart) {
                $cart = Cart::guestIndex($cart);
            }
        }

        return $cart;
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
