<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // user list and page
    public function UserPage()
    {
        // check if the role is admin or not
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

                $users = User::all();
                // returning the list of users and the view
                return view('admin.users.admin_users', compact('users', 'notifications'));
            }
        } else {
            return redirect()->route('loginpage');
        }
    }

    // add user page
    public function AddUserPage()
    {
        // check if the role is admin or not
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
                // returning the view of add users
                return view('admin.users.admin_addusers', compact('notifications'));
            }
        } else {
            return redirect()->route('loginpage');
        }
    }

    public function AddUserRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'contact' => 'required|min:11',
            'address' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = new User([
                'fullname' => $request->input('fullname'),
                'contact' => $request->input('contact'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => Hash::make($request->input('password')),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->save();
            return redirect()->route('admin.addusers')->with('success', 'User added successfully');
        }
    }


    // update user page
    public function UpdateUserPage($id)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user is not an admin, redirect them to login page
            if (
                Auth::user()->role !== 'admin'
            ) {
                return redirect()->route('loginpage');
            } else {
                // Retrieve notifications
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

                // Retrieve the user
                $user = User::find($id);

                // Check if the user exists
                if (!$user) {
                    return redirect()->route('admin.users')->with('error', 'User not found');
                }

                // Return the view with user, notifications, and old role
                return view('admin.users.admin_update_user', [
                    'user' => $user,
                    'old_role' => old('role', $user->role),
                    'notifications' => $notifications,
                ]);
            }
        } else {
            // Redirect unauthenticated users to the login page
            return redirect()->route('loginpage');
        }
    }


    // update user request
    public function UpdateUserRequest(Request $request, $id)
    {
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $user = User::find($id);

                $validator = Validator::make($request->all(), [
                    'fullname' => 'required|string',
                    'contact' => 'required|min:11',
                    'address' => 'required|string',
                    'email' => [
                        'required', 'email', Rule::unique('users')->ignore($user->id),
                    ],
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                    'role' => 'required',
                ]);

                // validation error
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    // if success the validation
                    $user->update([
                        'fullname' => $request->input('fullname'),
                        'contact' => $request->input('contact'),
                        'address' => $request->input('address'),
                        'email' => $request->input('email'),
                        'role' => $request->input('role'),
                        'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
                        'updated_at' => now(),
                    ]);
                    return redirect()->route('admin.updateusers', ['id' => $user->id])->with('success', 'User updated successfully');
                }
            }
        } else {
            return redirect()->route('loginpage');
        }
    }

    // delete user
    public function DeleteUserRequest($id)
    {
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $user = User::find($id);
                if (!$user) {
                    return redirect()->route('admin.users')->with('error', 'User not found');
                } else {
                    $user->delete();
                    return redirect()->route('admin.users')->with('success', 'User deleted successfully');
                }
            }
        } else {
            return redirect()->route('loginpage');
        }
    }
}
