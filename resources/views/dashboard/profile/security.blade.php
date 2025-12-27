@extends('layouts.app')
@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Security Settings</h1>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-6">
            <h3 class="text-lg font-bold mb-4">Change Password</h3>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <input type="password" name="current_password" placeholder="Current Password"
                        class="block w-full rounded-md border-gray-300 dark:bg-gray-700">
                    <input type="password" name="password" placeholder="New Password"
                        class="block w-full rounded-md border-gray-300 dark:bg-gray-700">
                    <input type="password" name="password_confirmation" placeholder="Confirm New Password"
                        class="block w-full rounded-md border-gray-300 dark:bg-gray-700">
                </div>
                <button type="submit" class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Update
                    Password</button>
            </form>
        </div>
    </div>
@endsection