<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer(['page.cart', 'page.home', 'page.single_product', 'page.checkout', 'auth.login', 'auth.register', 'page.track_orders', 'page.shop', 'page.show_orders', 'page.contact', 'page.myprofile'], function ($view) {
            $customer_id = auth()->id();

            $cart_items = Cart::where('customer_id', $customer_id)->with('product')->get();
            $cart_items = $cart_items ?? [];

            $total_price = $cart_items->sum(function ($cart_item) {
                return $cart_item->product->product_price * $cart_item->quantity;
            });

            $view->with('cart_items', $cart_items);
            $view->with('total_price', $total_price);
        });
    }
}
