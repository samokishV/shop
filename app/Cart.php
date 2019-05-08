<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
}
