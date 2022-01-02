<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function update(User $user)
    {
        $user->ott = Str::random(255);
        $user->save();

        Mail::to($user)
            ->queue(new PasswordResetMail($user));
        session()->flash('success', 'Password reset email sent successfully');

        return redirect()->back();
    }
}
