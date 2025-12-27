@extends('layouts.admin')
@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Banners</h1>
            <a href="{{ route('admin.banners.create') }}" class="btn-primary">Add Banner</a>
        </div>
        <div class="card">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Active</th>
                        <th>Priority</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                        <tr>
                            <td>{{ $banner->title }}</td>
                            <td>{{ $banner->type }}</td>
                            <td>{{ $banner->is_active ? 'Yes' : 'No' }}</td>
                            <td>{{ $banner->priority }}</td>
                            <td>
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="text-blue-600">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection