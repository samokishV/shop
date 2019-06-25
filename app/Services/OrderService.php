<?php

namespace App\Services;

use App\Mail\ManagerOrderMail;
use App\Notifications\UserOrderMail;
use App\Order;
use App\ProductsOrder;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    /**
     * @param array $userInfo | ['name' => string , 'email' => string , 'phone' => string, 'address' => string]
     * @param CartService $cart
     */
    public function create($userInfo, $cart)
    {
        $userId = Auth::id();

        $total = $cart->getTotal();
        $products = $cart->getProducts();

        // save order to DB
        $order = Order::store($userId, $userInfo, $total, $products);
        $orderId = $order->id;

        foreach ($products as $item) {
            ProductsOrder::store($orderId, $item->id, $item->qt, $item->total);
            Order::productQtDecrease($item->id, $item->qt);
        }

        $cart->clear();

        $userInfo = Order::find($orderId);
        $order = Order::getById($orderId);

        //send mail to user and manager
        Auth::user()->notify(new UserOrderMail());

        $user = new User();
        $user->email = $userInfo->email;
        $user->notify(new UserOrderMail());

        $managers = User::findByRole('manager');
        foreach ($managers as $manager) {
            Mail::to($manager->email)->send(new ManagerOrderMail($userInfo, $order));
        }
    }

    /**
     * @param int $id
     * @param string $processed
     */
    public function updateStatus($id, $processed)
    {
        if ($processed=="on") {
            $status = 1;
        } else {
            $status = 0;
        }

        Order::changeStatus($id, $status);
    }
}
