<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tool;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Enforce Password Change for Default Admin
        // In a real app, use a proper middleware or 'must_change_password' column.
        if (\Illuminate\Support\Facades\Hash::check('admin123', auth()->user()->password)) {
            session()->flash('error', 'Security Alert: You are using the default password. Please change it immediately.');
            // return redirect()->route('profile.edit'); // Redirect to profile to change it
        }

        // Stats
        $totalUsers = User::count();
        $newUsers = User::whereDate('created_at', today())->count();
        $totalTools = Tool::count();
        $recentActivity = ActivityLog::latest()->take(10)->get();

        return view('admin.dashboard', compact('totalUsers', 'newUsers', 'totalTools', 'recentActivity'));
    }

    public function usersIndex()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toolsIndex()
    {
        $tools = Tool::all();
        return view('admin.tools.index', compact('tools'));
    }

    public function logsIndex()
    {
        $logs = ActivityLog::latest()->paginate(50);
        return view('admin.logs.index', compact('logs'));
    }
}
