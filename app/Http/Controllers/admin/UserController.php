<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                $users = User::all();
                // returning the list of users and the view
                return view('admin.users.admin_users', compact('users'));
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
                // returning the view of add users
                return view('admin.users.admin_addusers');
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
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $user = User::find($id);

                if (!$user) {
                    return redirect()->route('admin.users')->with('error', 'User not found');
                }

                return view('admin.users.admin_update_user', [
                    'user' => $user,
                    'old_role' => old('role', $user->role),
                ]);
            }
        } else {
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
