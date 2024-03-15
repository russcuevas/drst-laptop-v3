<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // login page
    public function LoginPage()
    {
        if (Auth::check()) {
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/admin_dashboard');
                    break;
                case 'staff':
                    return redirect('/staff/staff_dashboard');
                    break;
                case 'customers':
                    return redirect('/home');
                    break;
                default:
                    return redirect('/login');
            }
        } else {
            return view('auth.login');
        }
    }


    // login request
    public function LoginRequest(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    $redirect_route = '/admin/admin_dashboard';
                    break;
                case 'staff':
                    $redirect_route = '/staff/staff_dashboard';
                    break;
                case 'customers':
                    $redirect_route = '/home';
                    break;
                default:
                    $redirect_route = '/login';
            }
            return redirect($redirect_route);
        } else {
            return redirect('/login')->with('error', 'Invalid credentials');
        }
    }


    // register page
    public function RegisterPage()
    {
        if (Auth::check()) {
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/admin_dashboard');
                    break;
                case 'staff':
                    return redirect('/staff/staff_dashboard');
                    break;
                case 'customers':
                    return redirect('/home');
                    break;
                default:
                    return redirect('/registration');
            }
        } else {
            return view('auth.register');
        }
    }


    // register request
    public function RegisterRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'contact' => 'required|min:11',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            User::create([
                'fullname' => $request->input('fullname'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'contact' => $request->input('contact'),
                'address' => $request->input('address'),
                'role' => 'customers',
            ]);
            return redirect()->route('loginpage')->with('success', 'Registration successful. You can now log in.');
        }
    }

    // logout request
    public function Logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
