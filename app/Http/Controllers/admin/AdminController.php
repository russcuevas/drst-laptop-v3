<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        // check if the role is admin or not
        if (Auth::check()) {
            // if not it will redirect to loginpage
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                // else it will go to dashboard
                $get_total_users = User::count();
                $get_total_products = Product::count();
                $get_total_sales = Reports::sum('total_amount');
                $get_completed = Reports::where('status', 'Delivered')->count();
                $recentOrders = $this->getRecentOrders();
                $get_low_stock_products = $this->getLowStockProducts();
                return view('admin.admin_dashboard', compact('get_total_users', 'get_total_products', 'get_total_sales', 'get_completed', 'recentOrders', 'get_low_stock_products'));
            }
        }
        // else not authenticated it will navigate to loginpage
        return redirect()->route('loginpage');
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
                // else it will go to update profile page
                $user = Auth::user();
                return view('admin.profile.admin_updateprofile', compact('user'));
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
