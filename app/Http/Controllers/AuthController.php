<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    function welcome(Request $request, $email = null)
    {
        $user = User::where('email', $request->email)->first();
        if ($user && ($user->email_verified_at) == null) {
            return view('auth.welcome', compact(['user', 'email']));
        } else {
            return abort(404)->with('message', 'User with that email doesn\'t exit, or you have already verified your account');
        }
    }

    function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:3|max:25'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && ($user->email_verified_at) == null) {
            $saved = User::where('email', $request->email)
                ->update([
                    'password' => Hash::make($request->password),
                    'email_verified_at' => now()
                ]);
        } else {
            return abort(404)->with('message', 'User with that email doesn\'t exit, or you have already verified your account');
        }

        $messages = 'Password updated successfully';
        if ($saved) {
            session()->flash('success', $messages);
        }

        return redirect()->route('home')->with('success', $messages);
    }
}