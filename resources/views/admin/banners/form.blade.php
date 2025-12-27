@extends('layouts.admin')
@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">{{ isset($banner) ? 'Edit Banner' : 'Create Banner' }}</h1>
        <form action="{{ isset($banner) ? route('admin.banners.update', $banner->id) : route('admin.banners.store') }}"
            method="POST">
            @csrf
            @if(isset($banner)) @method('PUT') @endif

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" value="{{ $banner->title ?? '' }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Message</label>
                <textarea name="message" class="w-full border rounded px-3 py-2">{{ $banner->message ?? '' }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Save Banner</button>
        </form>
    </div>
@endsection