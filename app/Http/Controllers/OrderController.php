<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController
{
    /**
     * Show the form for creating a new resource.
     *
     * @param CartService $cart
     * @return Response
     */
    public function create(CartService $cart)
    {
        $userId = Auth::id();
        $products = $cart->getProducts($userId);
        return view('order', ['cart'=>$products]);
    }

    /**
     * @param StoreOrder $request
     * @param OrderService $order
     * @return Factory|View
     */
    public function store(StoreOrder $request, OrderService $order)
    {
        $order->create($request);
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
     * @param int $id
     * @param OrderService $order
     * @return Response
     */
    public function update(Request $request, $id, OrderService $order)
    {
        $processed = $request['processed'];
        $order->updateStatus($id, $processed);

        return redirect(route('admin.order.index'));
    }
}
