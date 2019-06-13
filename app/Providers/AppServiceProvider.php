<?php

namespace App\Providers;

use App\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $productsQt = Cart::count($userId);
            } else {
                if (Session::has('cart')) {
                    $cart = Session::get('cart');
                    $cartObj = new CartService();
                    $productsQt = $cartObj->countProducts($cart);
                } else {
                    $productsQt = 0;
                }
            }

            View::share('productsQt', $productsQt);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
