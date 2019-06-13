<?php

namespace App\Services;

use App\Cart;
use App\Mail\ManagerOrderMail;
use App\Notifications\UserOrderMail;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        $userId = Auth::id();
        $userInfo = $request->only(['name', 'email', 'phone', 'address']);
        $total = Cart::getTotal($userId);
        $cart = Cart::getByUserId($userId);
        $orderId = Order::store($userId, $userInfo, $total, $cart);

        $userInfo = Order::find($orderId);
        $order = Order::getById($orderId);

        //send mail to user and manager
        $request->user()->notify(new UserOrderMail());

        $user = new User();
        $user->email = $request->email;
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
