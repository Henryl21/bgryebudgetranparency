<?php

namespace App\Http\Controllers\Treasurer;

use App\Http\Controllers\Controller;

class TreasurerDashboardController extends Controller
{
    public function index()
    {
        // Redirect Treasurer to the admin budget index page
        return redirect()->route('admin.budget.index');
    }
}
