<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function MyProfilePage()
    {
        if (Auth::check()){
            if (Auth::user()->role !== 'customers') {
                return redirect()->route('loginpage');
            } else {
                $user = Auth::user();
                return view('page.myprofile', compact('user'));
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
