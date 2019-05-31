<?php

namespace App\Listeners;

use App\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogSuccessfulLogin
{
    /**
    * Create the event listener.
    *
    * @return void
    */
    public function __construct()
    {
    //
    }

    /**
    * Handle the event.
    *
    * @param  Login  $event
    * @return void
    */
    public function handle(Login $event)
    {
        $cart = Session::get('cart');
        if($cart) {
            $userId = $event->user->id;
            foreach($cart as $productId=>$qt) {
                Cart::add($userId, $productId, $qt);
            }
        }
    }
}
