<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;

class DashboardController extends Controller
{
    public function dashboardAdmin()
    {
        $counts = Dashboard::getCounts();

        return view('applications.mbkm.admin.dashboard', $counts);
    }
}
