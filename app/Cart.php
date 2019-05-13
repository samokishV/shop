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
     * @return array
     */
    public static function findById($userId, $productId)
    {
        return DB::select('select * from carts where user_id = ? and product_id = ?', [$userId, $productId]);
    }

    /**
     * @param int $userId
     * @param string $productId
     * @param string $qt
     */
    public static function add($userId, $productId, $qt)
    {
        $cart = new Cart;

        $cart->user_id = $userId;
        $cart->product_id = $productId;
        $cart->qt = $qt;

        $cart->save();
    }

    /**
     * @param int $userId
     * @param string $productId
     * @return int
     */
    public static function deleteById($userId, $productId)
    {
        return DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    /**
     * @param $userId
     * @return int
     */
    public static function deleteAll($userId)
    {
        return DB::table('carts')
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * @param int $userId
     * @param string $productId
     * @param $qt
     * @return void
     */
    public static function updateById($userId, $productId, $qt)
    {
        $product = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->firstOrFail();

        $product->qt = $qt;

        $product->save();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public static function index($userId)
    {
        $products =  DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', '=', $userId)
            ->select('products.*', 'carts.qt', DB::raw('price*qt as total'))
            ->get();

        return $products;
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function count($userId)
    {
        return DB::select('select count(product_id) as productsQt from carts where user_id = ?', [$userId]);
    }

    /**
     * @param $userId
     * @return int
     */
    public static function getTotal($userId)
    {
        $products = Cart::index($userId);

        $total = 0;
        foreach($products as $product) {
            $total += $product->total;
        }

        return $total;
    }
}
