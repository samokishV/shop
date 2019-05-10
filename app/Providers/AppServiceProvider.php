<?php

namespace App\Providers;

use App\Cart;
use Illuminate\Support\Facades\Auth;
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
        View::composer('*', function($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $productsQt = Cart::count($userId)[0]->productsQt;
            } else $productsQt = 0;

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
