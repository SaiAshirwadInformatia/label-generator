<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function index(User $user)
    {
        return view('auth.activate', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $user->ott = null;
        $user->password = $request->password;
        $user->email_verified_at = Carbon::now();
        $user->save();

        auth()->login($user);

        session()->flash('success', "Your account activated successfully");

        return redirect()->route('dashboard');
    }
}
