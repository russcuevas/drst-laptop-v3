<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function InvoicePage()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $orderNotifications = DB::table('order_notifications')
                    ->join('orders', 'order_notifications.order_id', '=', 'orders.id')
                    ->select(
                        'orders.reference_number',
                        'orders.invoice_number',
                        'order_notifications.message',
                        DB::raw('MAX(orders.id) as order_id'),
                        DB::raw('MAX(order_notifications.created_at) as notification_created_at')
                    )
                    ->where('order_notifications.is_seen', false)
                    ->groupBy('orders.reference_number', 'orders.invoice_number', 'order_notifications.message')
                    ->orderBy('notification_created_at', 'desc')
                    ->get();

                $productNotifications = \App\Models\ProductNotifications::with('product')
                    ->where('is_seen', false)
                    ->orderBy('created_at', 'desc')
                    ->get();


                // Merge order and product notifications
                $notifications = $orderNotifications->merge($productNotifications);

                $invoices = DB::table('order_details')
                    ->join('orders', 'order_details.id', '=', 'orders.order_details_id')
                    ->join('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                    ->join('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                    ->select(
                        'orders.reference_number',
                        'orders.invoice_number',
                        DB::raw('SUM(order_details.total_amount) as total_amount'),
                        'orders.payment_method',
                        'orders.created_at as order_created_at',
                        'order_statuses.status as order_status',
                        'order_initial_statuses.initial_status as order_initial_status'
                    )
                    ->groupBy('orders.reference_number', 'orders.invoice_number', 'orders.payment_method', 'orders.created_at', 'order_statuses.status', 'order_initial_statuses.initial_status')
                    ->get();

                return view('admin.invoice.admin_invoice', ['invoices' => $invoices, 'notifications' => $notifications]);
            }
        } else {
            return redirect()->route('loginpage');
        }
    }


    public function ShowInvoice($InvoiceNumber)
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $invoices = DB::table('order_details')
                    ->join('orders', 'order_details.id', '=', 'orders.order_details_id')
                    ->join('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                    ->join('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                    ->where('orders.invoice_number', $InvoiceNumber)
                    ->select(
                        'order_details.*',
                        'orders.reference_number',
                        'orders.invoice_number',
                        'orders.payment_method',
                        'orders.created_at as order_created_at',
                        'order_statuses.status as order_status',
                        'order_initial_statuses.initial_status as order_initial_status'
                    )
                    ->get();

                return view('admin.invoice.admin_view_invoice', ['invoices' => $invoices]);
            }
        } else {
            return redirect()->route('loginpage');
        }
    }
}
