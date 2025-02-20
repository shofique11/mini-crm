<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getStats()
    {
        // Count total leads
        $totalLeads = Lead::count();

        // Count total counselors (assuming role = 'counselor')
        $totalCounselors = User::where('role', 'counselor')->count();

        // Count total applications
        $totalApplications = Application::count();

        return response()->json([
            'total_leads' => $totalLeads,
            'total_counselors' => $totalCounselors,
            'total_applications' => $totalApplications,
        ]);
    }

    public function getStatsMe()
    {
        // Count total leads
        $totalLeads = Lead::Where('counselor_id', auth()->user()->id)->whereDoesntHave('application')->count();
        // Count total applications
        $totalApplications = Application::Where('counselor_id', auth()->user()->id)->count();

        return response()->json([
            'total_leads' => $totalLeads,
            'total_applications' => $totalApplications,
        ]);
    }
}
