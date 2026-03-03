<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService)
    {
        // $this->dashboardService = $dashboardService;
    }

    public function index()


    {
        $user = auth()->user();

        // Use the service to get the appropriate data array
        $data = $user->isAdmin()
            ? $this->dashboardService->getAdminStats()
            : $this->dashboardService->getCustomerStats($user);

        return view('dashboard', $data);
    }
}