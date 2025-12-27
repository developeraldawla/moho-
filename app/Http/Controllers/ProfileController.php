<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile.index', ['user' => auth()->user()]);
    }
    public function update(Request $request)
    {
        auth()->user()->update($request->all());
        return back()->with('success', 'Profile updated');
    }
    public function security()
    {
        return view('dashboard.profile.security');
    }
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Incorrect password']);
        }
        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated');
    }
    public function sessions()
    {
        // Logic to show sessions
        return view('dashboard.profile.security');
    }
    public function logoutSession($id)
    {
        // Logic to kill session
        return back();
    }
    public function linkGoogle()
    {
        return redirect()->route('google.login');
    }
    public function unlinkGoogle()
    {
        auth()->user()->update(['google_id' => null]);
        return back();
    }
}
