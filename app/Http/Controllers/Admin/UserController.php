<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of registered users for the admin's barangay.
     */
    public function index(Request $request)
    {
        // ✅ Get logged-in admin
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = strtolower($currentAdmin->barangay_role); // e.g., 'barangay_1'

        // ✅ Base query for users
        $query = User::query();

        // ✅ Filter users by same barangay role as admin
        $query->whereRaw('LOWER(barangay_role) = ?', [$barangayRole]);

        // ✅ Optional search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('full_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('number', 'LIKE', "%{$searchTerm}%");
            });
        }

        // ✅ Fetch users ordered by newest first
        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users', 'barangayRole'));
    }
}
