<?php

namespace App\Services;

use App\Cart;
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
     */
    public function create($userInfo)
    {
        $userId = Auth::id();

        $total = Cart::getTotal($userId);
        $cart = Cart::getByUserId($userId);

        // save order to DB
        $order = Order::store($userId, $userInfo, $total, $cart);
        $orderId = $order->id;

        foreach ($cart as $item) {
            ProductsOrder::store($orderId, $item->id, $item->qt, $item->total);
            Order::productQtDecrease($item->id, $item->qt);
        }

        Cart::deleteAll($userId);

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
