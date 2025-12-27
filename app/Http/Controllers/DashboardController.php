<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\SavedWork;
use App\Models\UsageLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Stats
        $usageCount = UsageLog::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        $savedCount = SavedWork::where('user_id', $user->id)->count();

        // Subscription check (mock)
        $trialDaysLeft = 3; // Placeholder logic

        // 2. Recent Saved Works
        $recentWorks = SavedWork::where('user_id', $user->id)
            ->with('tool')
            ->latest()
            ->take(5)
            ->get();

        // 3. Recommended Tools (Active & Popular)
        $recommendedTools = Tool::where('is_active', true)
            ->take(6)
            ->get();

        return view('dashboard.index', compact('user', 'usageCount', 'savedCount', 'recentWorks', 'recommendedTools', 'trialDaysLeft'));
    }
}
