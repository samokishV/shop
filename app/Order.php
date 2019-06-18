<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @param int $userId
     * @param array $userInfo | $userInfo['name' => string, 'email'=> string, 'phone' => string, 'address' => string]
     * @param int $total
     * @param array $cart | An array of cart objects. | $cart[{'id'=> int, 'qt' => int, 'total' => int}]
     * @return Order
     */
    public static function store($userId, $userInfo, $total, $cart)
    {
        $order = new Order;

        $order->user_id = $userId;
        $order->name = $userInfo['name'];
        $order->email = $userInfo['email'];
        $order->phone = $userInfo['phone'];
        $order->address = $userInfo['address'];
        $order->total = $total;

        $order->save();

        return $order;
    }

    /**
     * @param int $id
     * @param string $qt
     */
    public static function productQtDecrease($id, $qt)
    {
        $product = Product::find($id);
        $product->in_stock = $product->in_stock - $qt;
        $product->save();
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function index($userId)
    {
        return Order::where('user_id', '=', $userId)
            ->join('products_orders', 'orders.id', '=', 'products_orders.order_id')
            ->join('products', 'products_orders.product_id', '=', 'products.id')
            ->select('products_orders.*', 'orders.id', 'products.title', DB::raw('round(products_orders.total/qt,2) as price'))
            ->orderBy('orders.id')
            ->get();
    }

    /**
     * @param int $orderId
     * @return array
     */
    public static function getById($orderId)
    {
        return Order::where('orders.id', '=', $orderId)
            ->join('products_orders', 'orders.id', '=', 'products_orders.order_id')
            ->join('products', 'products_orders.product_id', '=', 'products.id')
            ->select(
                'orders.id',
                'orders.name',
                'orders.email',
                'orders.phone',
                'orders.address',
                'products_orders.*',
                'products.title',
                DB::raw('round(products_orders.total/qt,2) as price')
            )
            ->get();
    }

    /**
     * @param int $id
     * @param bool $status
     */
    public static function changeStatus($id, $status)
    {
        $order = Order::find($id);
        $order->processed = $status;
        $order->save();
    }
}
