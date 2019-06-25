<?php

namespace App\Providers;

use App\Services\CartService;
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

            if (Session::has('cart')) {
                $cartObj = new CartService();
                $productsQt = $cartObj->countProducts();
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
