<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function ShopPage()
    {
        $top_products = DB::table('top_products')
            ->join('products', 'top_products.product_id', '=', 'products.id')
            ->select('products.id', 'products.product_name', 'products.product_picture', 'products.product_type', 'products.product_grain', 'products.product_net_wt', 'products.product_price', 'top_products.total_sold')
            ->orderBy('top_products.total_sold', 'desc')
            ->take(3)
            ->get();

        $product_count = Product::count();
        $all_products = Product::paginate(6);

        $notifications = [];

        // Check if the user is authenticated
        if (auth()->check()) {
            $user_id = auth()->user()->id;

            $notifications = DB::table('order_notifications')
                ->join('orders', 'order_notifications.order_id', '=', 'orders.id')
                ->select(
                    'orders.reference_number',
                    'orders.invoice_number',
                    DB::raw('MAX(order_notifications.message) AS message'),
                    DB::raw('MAX(orders.id) as order_id'),
                    DB::raw('MAX(order_notifications.created_at) as notification_created_at')
                )
                ->where('order_notifications.is_customer_seen', 0)
                ->where('order_notifications.customer_id', $user_id)
                ->groupBy('orders.reference_number', 'orders.invoice_number')
                ->orderBy('notification_created_at', 'desc')
                ->get();
        }

        return view('page.shop', compact('all_products', 'product_count', 'top_products', 'notifications'));
    }

    public function FilterByGrain(Request $request)
    {
        $grain_type = $request->input('grain');
        $filtered_products = Product::where('product_grain', $grain_type)->get();

        $top_products = DB::table('top_products')
            ->join('products', 'top_products.product_id', '=', 'products.id')
            ->select('products.id', 'products.product_name', 'products.product_picture', 'products.product_type', 'products.product_grain', 'products.product_net_wt', 'products.product_price', 'top_products.total_sold')
            ->orderBy('top_products.total_sold', 'desc')
            ->take(3)
            ->get();

        $product_count = Product::count();
        $all_products = $filtered_products;

        $notifications = [];

        // Check if the user is authenticated
        if (auth()->check()) {
            $user_id = auth()->user()->id;

            $notifications = DB::table('order_notifications')
                ->join('orders', 'order_notifications.order_id', '=', 'orders.id')
                ->select(
                    'orders.reference_number',
                    'orders.invoice_number',
                    DB::raw('MAX(order_notifications.message) AS message'),
                    DB::raw('MAX(orders.id) as order_id'),
                    DB::raw('MAX(order_notifications.created_at) as notification_created_at')
                )
                ->where('order_notifications.is_customer_seen', 0)
                ->where('order_notifications.customer_id', $user_id)
                ->groupBy('orders.reference_number', 'orders.invoice_number')
                ->orderBy('notification_created_at', 'desc')
                ->get();
        }

        return view('page.shop', compact('all_products', 'product_count', 'top_products', 'grain_type', 'notifications'));
    }
}
