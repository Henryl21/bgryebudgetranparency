<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Models\OfficerActivity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Get logs (latest first)
        $userLogs = UserActivity::latest()->limit(50)->get();
        $officerLogs = OfficerActivity::latest()->limit(50)->get();

        return view('admin.activity_logs.index', compact('userLogs', 'officerLogs'));
    }
}
