<?php

namespace App\Providers;

use App\Cart;
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
        View::composer('*', function($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $productsQt = Cart::count($userId)[0]->productsQt;
            } else {
                if(Session::has('cart')) {
                    $cart = Session::get('cart');
                    $productsQt = Cart::countProducts($cart);
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
