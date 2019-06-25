<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\View as View;
use Illuminate\Support\ServiceProvider;

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

            $cart = new CartService();

            if ($cart->exists()) {
                $productsQt = $cart->countProducts();
            } else {
                $productsQt = 0;
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
