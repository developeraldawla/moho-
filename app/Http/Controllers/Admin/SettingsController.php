<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = []; // Load settings
        return view('admin.settings', compact('settings'));
    }
    public function update(Request $request)
    {
        // Save settings logic
        return back()->with('success', 'Settings updated');
    }
}
