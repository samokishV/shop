<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Requests\StoreOrder;
use App\Order;
use App\User;
use App\Mail\ManagerOrderMail;
use App\Notifications\UserOrderMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class OrderController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $userId = Auth::id();
        $cart = Cart::getByUserId($userId);

        if (!$userId) {
            $cart = Session::get("cart");
            if ($cart) {
                $cart = Cart::guestIndex($cart);
            }
        }

        return view('order', ['cart'=>$cart]);
    }

    /**
     * @param StoreOrder $request
     * @return Factory|View
     */
    public function store(StoreOrder $request)
    {
        // save an order
        $userId = Auth::id();
        $userInfo = $request->only(['name', 'email', 'phone', 'address']);
        $total = Cart::getTotal($userId);
        $cart = Cart::getByUserId($userId)->toArray();
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

        return redirect(route('order.history'));
    }

    /**
     * Display a listing of the resource for definite user
     *
     * @return Response
     */
    public function show()
    {
        $userId = Auth::id();
        $orders = Order::index($userId);

        return view('order-history', ['orders'=>$orders]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $info = Order::find($id);
        $products = Order::getById($id);
        return view('orders.edit', ['info' => $info,'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $processed = $request['processed'];

        if ($processed=="on") {
            $status = 1;
        } else {
            $status = 0;
        }

        Order::changeStatus($id, $status);

        return redirect(route('admin.order.index'));
    }
}
