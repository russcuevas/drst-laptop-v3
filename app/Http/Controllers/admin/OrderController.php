<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function OrderPage()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $orders = DB::table('order_details')
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

                $display_one_orders = $orders->unique(function ($order) {
                    return $order->reference_number;
                });

                return view('admin.orders.admin_orders', ['orders' => $display_one_orders]);
            }
        } else {
            return redirect()->route('loginpage');
        }
    }


    public function ShowOrdersByReferenceAndInvoice($ReferenceNumber, $InvoiceNumber)
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $orders = DB::table('order_details')
                    ->join('orders', 'order_details.id', '=', 'orders.order_details_id')
                    ->join('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                    ->join('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                    ->where('orders.reference_number', $ReferenceNumber)
                    ->where('orders.invoice_number', $InvoiceNumber)
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

                return view('admin.orders.admin_edit_orders', ['orders' => $orders]);
            }
        } else {
            return redirect()->route('loginpage');
        }
    }

    public function updateOrdersStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:On process,On the way,Delivered',
        ]);

        $referenceNumber = $request->input('referenceNumber');
        $invoiceNumber = $request->input('invoiceNumber');
        $status = $request->input('status');
        $initialStatus = $status;


        if ($status === 'Placed orders') {
            DB::table('orders')
                ->leftJoin('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                ->leftJoin('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.invoice_number', $invoiceNumber)
                ->update(['order_initial_statuses.initial_status' => 'Placed orders']);

            $initialStatus = 'Placed orders';
        } elseif ($status === 'On process') {
            DB::table('orders')
                ->leftJoin('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                ->leftJoin('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.invoice_number', $invoiceNumber)
                ->update([
                    'order_initial_statuses.initial_status' => 'Placed orders',
                    'on_process_at' => now(),
                ]);

            $initialStatus = 'Placed orders';
        } elseif ($status === 'On the way') {
            DB::table('orders')
                ->leftJoin('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                ->leftJoin('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.invoice_number', $invoiceNumber)
                ->whereNull('order_initial_statuses.initial_status')
                ->update([
                    'order_initial_statuses.initial_status' => 'Placed orders',
                ]);

            DB::table('order_initial_statuses')
                ->leftJoin('order_statuses', 'order_initial_statuses.status_id', '=', 'order_statuses.id')
                ->leftJoin('orders', 'order_statuses.order_id', '=', 'orders.id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.invoice_number', $invoiceNumber)
                ->update([
                    'order_initial_statuses.on_the_way_at' => $request->input('on_the_way_at'),
                ]);

            $initialStatus = 'On process';
        } elseif ($status === 'Delivered') {
            DB::table('reports')->insert([
                'reference_number' => $referenceNumber,
                'invoice_number' => $invoiceNumber,
                'payment_method' => $request->input('payment_method'),
                'fullname' => $request->input('fullname'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'products_ordered' => $request->input('products_ordered'),
                'total_amount' => $request->input('total_amount'),
                'status' => $status,
                'ordered_date' => $request->input('ordered_date'),
                'receiving_date' => now(),
            ]);

            // inserting top products
            $products = $request->input('products');
            $quantities = $request->input('total_sold');

            foreach ($products as $key => $productId) {
                $totalQuantity = $quantities[$key];

                $existing_top_products = TopProducts::where('product_id', $productId)->first();

                if ($existing_top_products) {
                    $existing_top_products->total_sold += $totalQuantity;
                    $existing_top_products->save();
                } else {
                    $newTopProduct = new TopProducts([
                        'product_id' => $productId,
                        'total_sold' => $totalQuantity,
                    ]);
                    $newTopProduct->save();
                }
            }

            DB::table('orders')
                ->leftJoin('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                ->leftJoin('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.invoice_number', $invoiceNumber)
                ->update([
                    'order_initial_statuses.initial_status' => 'On the way',
                    'delivered_at' => now(),
                ]);

            DB::table('order_statuses')
                ->leftJoin('orders', 'order_statuses.order_id', '=', 'orders.id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.invoice_number', $invoiceNumber)
                ->update(['order_statuses.updated_at' => now()]);

            $initialStatus = 'On the way';
        }

        DB::table('orders')
            ->leftJoin('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
            ->leftJoin('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
            ->where('orders.reference_number', $referenceNumber)
            ->where('orders.invoice_number', $invoiceNumber)
            ->update([
                'order_statuses.status' => $status,
                'order_initial_statuses.initial_status' => $initialStatus,
            ]);

        return redirect()->back()->with('success', 'ORDER STATUS UPDATED SUCCESSFULLY');
    }

    public function CancelOrder($referenceNumber, $invoiceNumber)
    {
        DB::beginTransaction();

        try {
            $ordersToDelete = DB::table('orders')
                ->leftJoin('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
                ->leftJoin('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
                ->leftJoin('order_details', 'orders.order_details_id', '=', 'order_details.id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.invoice_number', $invoiceNumber)
                ->get();

            foreach ($ordersToDelete as $orderToDelete) {
                DB::table('products')
                    ->where('id', $orderToDelete->product_id)
                    ->increment('product_stocks', $orderToDelete->total_quantity);
            }

            DB::table('orders')
                ->where('reference_number', $referenceNumber)
                ->where('invoice_number', $invoiceNumber)
                ->delete();

            DB::table('order_statuses')
                ->whereIn('order_id', $ordersToDelete->pluck('id'))
                ->delete();

            DB::table('order_initial_statuses')
                ->whereIn('status_id', $ordersToDelete->pluck('status_id'))
                ->delete();

            DB::table('order_details')
                ->whereIn('id', $ordersToDelete->pluck('order_details_id'))
                ->delete();

            DB::commit();

            return redirect()->route('admin.orders')->with('success', 'Orders canceled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while canceling orders.');
        }
    }




    public function DeleteCompletedOrder($referenceNumber, $invoiceNumber)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            DB::table('orders')
                ->where('reference_number', $referenceNumber)
                ->where('invoice_number', $invoiceNumber)
                ->delete();

            return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
        } else {
            return redirect()->route('loginpage');
        }
    }
}
