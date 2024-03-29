<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyOrderController extends Controller
{
    public function MyOrderPage()
    {
        $customer_id = optional(Auth::user())->id;

        $ordersQuery = DB::table('order_details')
            ->join('orders', 'order_details.id', '=', 'orders.order_details_id')
            ->join('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
            ->join('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
            ->where('order_details.customer_id', $customer_id)
            ->select(
                'orders.reference_number',
                'orders.invoice_number',
                DB::raw('SUM(order_details.total_amount) as total_amount'),
                'orders.payment_method',
                'orders.created_at as order_created_at',
                'order_statuses.status as order_status',
                'order_initial_statuses.initial_status as order_initial_status'
            )
            ->groupBy('orders.reference_number', 'orders.invoice_number', 'orders.payment_method', 'orders.created_at', 'order_statuses.status', 'order_initial_statuses.initial_status');

        $orders = $ordersQuery->get();
        $display_one_orders = $orders->unique(function ($order) {
            return $order->reference_number;
        });

        $notifications = [];
        if (auth()->check()) {
            $user_id = auth()->user()->id;
            $notifications = $this->getNotifications($user_id);
        }

        return view('page.track_orders', ['orders' => $display_one_orders, 'notifications' => $notifications]);
    }

    private function getNotifications($user_id)
    {
        return DB::table('order_notifications')
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

    public function ShowMyOrders($ReferenceNumber)
    {
        $customer_id = optional(Auth::user())->id;

        if ($customer_id === null) {
            return redirect()->route('loginpage')->with('error', 'Please login first');
        }

        $notifications = [];

        // Define $notifications even if the user is not authenticated
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

        $orders = DB::table('order_details')
            ->join('orders', 'order_details.id', '=', 'orders.order_details_id')
            ->join('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
            ->join('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
            ->where('orders.reference_number', $ReferenceNumber)
            ->where('order_details.customer_id', $customer_id)
            ->select(
                'order_details.*',
                'orders.reference_number',
                'orders.invoice_number',
                'orders.payment_method',
                'orders.created_at as order_created_at',
                'order_statuses.status as order_status',
                'order_initial_statuses.initial_status as order_initial_status',
                'order_initial_statuses.placed_at',
                'order_initial_statuses.on_process_at',
                'order_initial_statuses.on_the_way_at',
                'order_initial_statuses.delivered_at',
            )
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('homepage')->with('error', 'No orders found');
        }

        return view('page.show_orders', ['orders' => $orders, 'notifications' => $notifications]);
    }

    public function CancelMyOrders(Request $request)
    {
        $referenceNumber = $request->input('referenceNumber');
        $customer_id = optional(Auth::user())->id;

        if ($customer_id === null) {
            return redirect()->route('loginpage')->with('error', 'Please login first');
        }

        $orders = DB::table('orders')
            ->join('order_details', 'orders.order_details_id', '=', 'order_details.id')
            ->select('orders.id', 'orders.order_details_id', 'order_details.product_id', DB::raw('SUM(order_details.total_quantity) as total_quantity'))
            ->where('orders.reference_number', $referenceNumber)
            ->where('order_details.customer_id', $customer_id)
            ->groupBy('orders.id', 'orders.order_details_id', 'order_details.product_id')
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('homepage')->with('error', 'No orders found');
        }

        foreach ($orders as $order) {
            $product_id = $order->product_id;
            $quantity = $order->total_quantity;

            DB::table('products')
                ->where('id', $product_id)
                ->increment('product_stocks', $quantity);

            DB::table('order_statuses')
                ->where('order_id', $order->id)
                ->delete();

            DB::table('order_details')
                ->where('id', $order->order_details_id)
                ->delete();

            DB::table('orders')
                ->where('reference_number', $referenceNumber)
                ->delete();
        }

        return redirect()->route('homepage')->with('success', 'Orders canceled successfully');
    }
}
