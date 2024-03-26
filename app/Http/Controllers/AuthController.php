<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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


    // forgot password
    public function ForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'This email is not found');
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = url('/password/reset/' . $token);

        Mail::to($user->email)->send(new ResetPasswordMail($user->fullname, $resetLink));
        return redirect('/login')->with('success', 'Password reset request is sent successfully, please check your email to change your password.')->with('resetLink', $resetLink);
    }

    public function ForgotForm($token)
    {
        if (!$token) {
            return redirect()->route('loginpage')->with('error', 'Invalid reset link');
        }

        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            return redirect()->route('loginpage')->with('error', 'Token not found or has expired try again');
        }

        return view('auth.password_reset', ['token' => $token]);
    }

    public function Reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed|between:8,12',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $passwordReset = PasswordReset::where('token', $request->token)->first();

        if (!$passwordReset) {
            return redirect('/login')->with('error', 'Token expired, request a new password reset');
        }

        $user = User::where('email', $passwordReset->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('token', $request->token)->delete();

        return redirect('/login')->with('success', 'Password reset successfully');
    }
}
