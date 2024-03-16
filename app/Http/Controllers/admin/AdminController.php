<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\OrderNotifications;
use App\Models\Product;
use App\Models\ProductNotifications;
use App\Models\Reports;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // admin dashboard
    public function AdminDashboard()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $get_total_users = DB::table('users')->count();
                $get_total_products = DB::table('products')->count();
                $get_total_sales = DB::table('reports')->sum('total_amount');
                $get_completed = DB::table('reports')->where('status', 'Delivered')->count();
                $recentOrders = $this->getRecentOrders();
                $get_low_stock_products = $this->getLowStockProducts();

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

                return view('admin.admin_dashboard', compact(
                    'get_total_users',
                    'get_total_products',
                    'get_total_sales',
                    'get_completed',
                    'recentOrders',
                    'get_low_stock_products',
                    'notifications'
                ));
            }
        }

        return redirect()->route('loginpage');
    }


    public function markNotificationAsSeen($referenceNumber)
    {
        $referenceNumber = request('referenceNumber');
        $invoiceNumber = request('invoiceNumber');

        $notification = DB::table('order_notifications')
            ->join('orders', 'order_notifications.order_id', '=', 'orders.id')
            ->where('orders.reference_number', $referenceNumber)
            ->select('order_notifications.*')
            ->first();

        if ($notification) {
            DB::table('order_notifications')
                ->join('orders', 'order_notifications.order_id', '=', 'orders.id')
                ->where('orders.reference_number', $referenceNumber)
                ->update(['order_notifications.is_seen' => true]);

            // return redirect()->back()->with('success', 'Notification marked as seen.');
        } else {
            // return redirect()->back()->with('error', 'Notification not found.');
        }
    }

    public function markNotificationProduct($id)
    {
        $notification = DB::table('product_notifications')->find($id);

        if ($notification) {
            DB::table('product_notifications')
                ->where('id', $id)
                ->update(['is_seen' => true]);

            // return redirect()->back()->with('success', 'Product notification marked as seen.');
        } else {
            // return redirect()->back()->with('error', 'Product notification not found.');
        }
    }


    // display recent orders
    public function getRecentOrders()
    {
        return DB::table('order_details')
            ->join('orders', 'order_details.id', '=', 'orders.order_details_id')
            ->join('users', 'order_details.customer_id', '=', 'users.id')
            ->join('order_statuses', 'orders.id', '=', 'order_statuses.order_id')
            ->join('order_initial_statuses', 'order_statuses.id', '=', 'order_initial_statuses.status_id')
            ->select(
                'orders.reference_number',
                'orders.invoice_number',
                DB::raw('SUM(order_details.total_amount) as total_amount'),
                'orders.payment_method',
                'orders.created_at as order_created_at',
                'order_statuses.status as order_status',
                'order_initial_statuses.initial_status as order_initial_status',
                'users.fullname as fullname'
            )
            ->groupBy('orders.reference_number', 'orders.invoice_number', 'orders.payment_method', 'orders.created_at', 'order_statuses.status', 'order_initial_statuses.initial_status', 'users.fullname')
            ->orderBy('order_created_at', 'desc')
            ->limit(5)
            ->get();
    }

    // low product display
    public function getLowStockProducts()
    {
        return Product::where('product_stocks', '<', 5)
            ->select('product_name', 'product_stocks', 'product_status', 'id')
            ->get();
    }

    // update profile
    public function UpdateProfile()
    {
        // check if the role is admin or not
        if (Auth::check()) {
            // if not it will redirect to loginpage
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
                // else it will go to update profile page
                $user = Auth::user();
                return view('admin.profile.admin_updateprofile', compact('user', 'notifications'));
            }
        } else {
            // else not authenticated it will navigate to loginpage
            return redirect()->route('loginpage');
        }
    }

    public function UpdateProfileRequest(Request $request)
    {
        // validation for updating the profile
        $request->validate([
            'fullname' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:6|max:255|confirmed',
        ]);

        $user = Auth::user();

        $data = [
            'fullname' => $request->fullname,
            'contact' => $request->contact,
            'address' => $request->address,
            'email' => $request->email,
        ];

        // update password return it to old even it is empty
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // display success message
        return redirect()->route('admin.updateprofile')->with('success', 'Profile updated successfully.');
    }
}
