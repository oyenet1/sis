<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    function show(User $user)
    {
        // $user = User::where('school_id', $school_id)->first();
        return view('users.profile', compact(['user']));
    }

    // login
    function boot()
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = Guardian::where('parent_id', $request->school_id)
                ->orWhere('email', $request->school_id)
                // ->orWhereRelation('guardian', 'parent_id', $request->school_id)
                // ->orWhereRelation('guardian', 'email', $request->school_id)
                // ->orWhereRelation('student', 'student_id', $request->school_id)
                ->first();
            if (
                $user &&
                Hash::check($request->password, $user->password)
            ) {
                return $user;
            }
        });
    }
}