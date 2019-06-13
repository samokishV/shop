<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'qt'
    ];

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
            Cart::create(['user_id' => $userId, 'product_id' => $productId, 'qt' => $qt]);
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
        return  Cart::join('products', 'carts.product_id', '=', 'products.id')
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
     * @param $userId
     * @return int
     */
    public static function getTotal($userId)
    {
        return Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', '=', $userId)
            ->sum(DB::raw('price * qt'));
    }
}
