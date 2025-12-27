@extends('layouts.app')
@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Profile Settings</h1>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" name="name" value="{{ $user->name }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update
                    Profile</button>
            </div>
        </form>

        <div class="mt-10 border-t pt-6">
            <h2 class="text-xl font-bold mb-4">Security</h2>
            <a href="{{ route('profile.security') }}" class="text-indigo-600 hover:text-indigo-800">Manage Password &
                Security settings &rarr;</a>
        </div>
    </div>
@endsection