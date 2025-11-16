<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function logout()
    {
        Auth::guard('admin')->logout(); // logout admin
        session()->invalidate();         // invalidate session
        session()->regenerateToken();    // regenerate CSRF token

        return redirect()->route('welcome'); // redirect to welcome page
    }
}
