<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsOrder extends Model
{
    /**
     * @param int $oderId
     * @param string $id
     * @param static $qt
     * @param int $total
     */
    public static function store($oderId, $id, $qt, $total)
    {
        $prod_order = new ProductsOrder;

        $prod_order->order_id = $oderId;
        $prod_order->product_id = $id;
        $prod_order->qt = $qt;
        $prod_order->total = $total;

        $prod_order->save();
    }
}
