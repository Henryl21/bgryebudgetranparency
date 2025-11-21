<?php

namespace App\Http\Controllers\Treasurer;

use App\Http\Controllers\Controller;
use App\Models\Treasurer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TreasurerAuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('treasurer.auth.login');
    }

    // Login logic
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('treasurer')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.budget.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Show register form
    public function showRegister()
    {
        return view('treasurer.auth.register');
    }

    // Register logic
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:treasurers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $treasurer = Treasurer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('treasurer')->login($treasurer);

        return redirect()->route('treasurer.login');
    }

    // Logout
    public function logout()
    {
        Auth::guard('treasurer')->logout();
        return redirect()->route('treasurer.login');
    }
}
