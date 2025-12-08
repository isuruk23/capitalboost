<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; // or App\Models\User depending on structure
use Illuminate\Support\Facades\Hash;

class UserPasswordResetController extends Controller
{
     public function showForm()
    {
        return view('auth.reset');
    }

    public function reset(Request $request)
    {
       
       $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('status', 'Password reset successfully!');
    }
}
