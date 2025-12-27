@extends('layouts.admin')
@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">{{ isset($plan) ? 'Edit Plan' : 'Create Plan' }}</h1>
        <form action="{{ isset($plan) ? route('admin.plans.update', $plan->id) : route('admin.plans.store') }}"
            method="POST">
            @csrf
            @if(isset($plan)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Name (EN)</label>
                    <input type="text" name="name_en" value="{{ $plan->name_en ?? '' }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Name (TR)</label>
                    <input type="text" name="name_tr" value="{{ $plan->name_tr ?? '' }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ $plan->price ?? '' }}"
                        class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Save Plan</button>
        </form>
    </div>
@endsection