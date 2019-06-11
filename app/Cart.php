<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    /**
     * @param int $userId
     * @param string $productId
     * @return Cart
     */
    public static function findProductById($userId, $productId)
    {
        return Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * @param int $userId
     * @param string $productId
     * @param string $qt
     */
    public static function add($userId, $productId, $qt)
    {
        $product = self::findProductById($userId, $productId);

        // update qt if product already in cart
        if ($product) {
            $product->qt = $qt;
            $product->save();
        } else {
            $cart = new Cart;

            $cart->user_id = $userId;
            $cart->product_id = $productId;
            $cart->qt = $qt;

            $cart->save();
        }
    }

    /**
     * @param int $userId
     * @param string $productId
     * @return int
     */
    public static function deleteProductById($userId, $productId)
    {
        return Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    /**
     * @param $userId
     * @return int
     */
    public static function deleteAll($userId)
    {
        return Cart::where('user_id', $userId)
            ->delete();
    }

    /**
     * @param int $userId
     * @param string $productId
     * @param $qt
     * @return bool
     */
    public static function updateById($userId, $productId, $qt)
    {
        $product = self::findProductById($userId, $productId);
        $product->qt = $qt;
        $product->save();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public static function getByUserId($userId)
    {
        return  DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', '=', $userId)
            ->select('products.*', 'carts.qt', DB::raw('price*qt as total'))
            ->get();
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function count($userId)
    {
        return self::where('user_id', $userId)->count();
    }

    /**
     * @param $userId
     * @return int
     */
    public static function getTotal($userId)
    {
        $products = Cart::getByUserId($userId);

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
     * Count products in cart array.
     *
     * @param Collection $cart | [string => string] | [id1 => qt, id2 => qt]
     * @return int
     */
    public static function countProducts($cart)
    {
        return count($cart);
    }

    /**
     * Get full info about product in cart.
     *
     * @param Collection $cart | [string => string] | [id1 => qt, id2 => qt]
     * @return Collection
     */
    public static function guestIndex($cart)
    {
        $cart = $cart->toArray();
        $keys = array_keys($cart);
        $products = DB::table('products')
            ->whereIn('id', $keys)
            ->get();

        foreach ($products as $product) {
            $product->qt = $cart[$product->id];
            $product->total = $product->qt*$product->price;
        }
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
}
