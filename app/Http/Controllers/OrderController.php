<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\User;
use App\Mail\ManagerOrderMail;
use App\Notifications\UserOrderMail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;

class OrderController
{
    /**
     * @return Factory|View
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            $request->flash();
            $userId = Auth::id();
            $cart = Cart::index($userId);
             return view('order', ['cart' => $cart])
                ->withErrors($validator);
        } else {
            // save an order
            $userId = Auth::id();
            $userInfo = $request->only(['name', 'email', 'phone', 'address']);
            $total = Cart::getTotal($userId);
            $cart = Cart::index($userId)->toArray();
            $orderId = Order::store($userId, $userInfo, $total, $cart);

            $order = Order::getById($orderId);

            //send mail to user and manager
            $request->user()->notify(new UserOrderMail());

            $user = new User();
            $user->email = $request->email;
            $user->notify(new UserOrderMail());

            $managers = User::findByRole('manager');
            foreach($managers as $manager) {
                Mail::to($manager->email)->send(new ManagerOrderMail($order));
            }

            return redirect('order/history');
        }
    }

    public function index()
    {
        $userId = Auth::id();
        $orders = Order::index($userId);

        return view('order-history', ['orders'=>$orders]);
    }
}
