@extends('layouts.admin')
@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Settings</h1>
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card mb-6 p-6">
                <h3 class="text-lg font-bold mb-4">General Settings</h3>
                <!-- Add fields here -->
            </div>

            <div class="card mb-6 p-6">
                <h3 class="text-lg font-bold mb-4">Stripe Settings</h3>
                <!-- Add fields here -->
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
@endsection