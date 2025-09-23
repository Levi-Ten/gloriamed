<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthCnamController extends Controller
{
    // Formular login
    public function showLogin()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // Proces login
    public function login(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('name', $request->name)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // Setăm sesiunea
        session(['user_cnam_id' => $user->id]);
        session(['user_cnam_role' => $user->role]);

        // =========================
        // Remember token
        // =========================
        if ($request->has('remember')) {
            $token = bin2hex(random_bytes(32)); // token securizat
            $user->remember_token = $token;
            $user->save();

            // punem token în cookie pentru 30 zile
            cookie()->queue('remember_cnam', $token, 60*24*30); // 60*24*30 = 30 zile
        }
        // =========================

        return redirect()->route('cnam.index');
    }

    return back()->withErrors(['name' => 'Nume sau parolă incorectă']);
}


    // Logout
    public function logout()
    {
        // Ștergem token-ul remember_token din baza de date
        if ($userId = session('user_cnam_id')) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                $user->remember_token = null;
                $user->save();
            }
        }
    
        // Ștergem sesiunea
        session()->flush();
    
        // Ștergem cookie-ul remember_cnam
        cookie()->queue(cookie()->forget('remember_cnam'));
    
        return redirect()->route('auth.login');
    }
    
}
