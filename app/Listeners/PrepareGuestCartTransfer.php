<?php

namespace App\Listeners;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PrepareGuestCartTransfer
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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if (Auth::guest()) {
            $sessionKey = Session::has('session_key') ? Session::get('session_key') : session()->getId();
          
            session()->flash('guest_cart', [
                'session' => $sessionKey,
                'data' => Cart::session($sessionKey)->getContent()
            ]);
        }
    }
}
