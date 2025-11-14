<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OfficerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display both Users and Officers for the admin's barangay.
     */
    public function index(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = strtolower($currentAdmin->barangay_role);

        // Fetch Users
        $usersQuery = User::query()
            ->whereRaw('LOWER(barangay_role) = ?', [$barangayRole]);

        if ($request->filled('search')) {
            $search = $request->search;
            $usersQuery->where(function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('number', 'LIKE', "%{$search}%");
            });
        }

        $usersQuery->with(['loginLogs' => function ($q) {
            $q->latest()->limit(1);
        }]);

        $users = $usersQuery->get();

        // Fetch Officers
        $officersQuery = OfficerUser::query()
            ->whereRaw('LOWER(barangay) = ?', [$barangayRole]);

        if ($request->filled('search')) {
            $search = $request->search;
            $officersQuery->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $officersQuery->with(['loginLogs' => function ($q) {
            $q->latest()->limit(1);
        }]);

        $officers = $officersQuery->get();

        // Merge users and officers with coordinates
        $accounts = $users->map(function ($user) {
            return (object)[
                'full_name'  => $user->full_name,
                'email'      => $user->email,
                'barangay'   => $user->barangay_role,
                'time_in'    => $user->loginLogs->first()?->time_in,
                'time_out'   => $user->loginLogs->first()?->time_out,
                'registered' => $user->created_at,
                'type'       => 'User',
                'latitude'   => $user->latitude,
                'longitude'  => $user->longitude,
            ];
        })->merge(
            $officers->map(function ($officer) {
                return (object)[
                    'full_name'  => $officer->name,
                    'email'      => $officer->email,
                    'barangay'   => $officer->barangay,
                    'time_in'    => $officer->loginLogs->first()?->time_in,
                    'time_out'   => $officer->loginLogs->first()?->time_out,
                    'registered' => $officer->created_at,
                    'type'       => 'Officer',
                    'latitude'   => $officer->latitude,
                    'longitude'  => $officer->longitude,
                ];
            })
        );

        // Sort by latest login time first
        $accounts = $accounts->sortByDesc(fn($account) => $account->time_in ?? $account->registered);

        return view('admin.users_officers.index', compact('accounts', 'barangayRole'));
    }

    /**
     * Show user/officer details
     */
    public function show($email)
    {
        $user = User::where('email', $email)->first();
        $officer = OfficerUser::where('email', $email)->first();

        if ($user) {
            $account = (object)[
                'full_name'  => $user->full_name,
                'email'      => $user->email,
                'barangay'   => $user->barangay_role,
                'time_in'    => $user->loginLogs->first()?->time_in,
                'time_out'   => $user->loginLogs->first()?->time_out,
                'registered' => $user->created_at,
                'type'       => 'User',
                'latitude'   => $user->latitude,
                'longitude'  => $user->longitude,
            ];
        } elseif ($officer) {
            $account = (object)[
                'full_name'  => $officer->name,
                'email'      => $officer->email,
                'barangay'   => $officer->barangay,
                'time_in'    => $officer->loginLogs->first()?->time_in,
                'time_out'   => $officer->loginLogs->first()?->time_out,
                'registered' => $officer->created_at,
                'type'       => 'Officer',
                'latitude'   => $officer->latitude,
                'longitude'  => $officer->longitude,
            ];
        } else {
            abort(404, 'User/Officer not found');
        }

        return view('admin.users_officers.show', compact('account'));
    }
}
