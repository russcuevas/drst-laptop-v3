<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function MyProfilePage()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'customers') {
                return redirect()->route('loginpage');
            } else {
                $user = Auth::user();

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

                return view('page.myprofile', compact('user', 'notifications'));
            }
        } else {
            return redirect()->route('loginpage');
        }
    }

    public function UpdateMyProfileRequest(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'contact' => 'required|string|min:11|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:6|max:20|confirmed',
        ]);

        $user = Auth::user();

        $data = [
            'fullname' => $request->fullname,
            'contact' => $request->contact,
            'address' => $request->address,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('myprofilepage')->with('success', 'Profile updated successfully.');
    }
}
