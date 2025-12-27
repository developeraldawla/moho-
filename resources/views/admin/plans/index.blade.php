@extends('layouts.admin')
@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Plans</h1>
            <a href="{{ route('admin.plans.create') }}" class="btn-primary">Add New Plan</a>
        </div>
        <div class="card">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name (EN)</th>
                        <th>Price</th>
                        <th>Interval</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                        <tr>
                            <td>{{ $plan->id }}</td>
                            <td>{{ $plan->name_en }}</td>
                            <td>{{ $plan->price }} {{ $plan->currency }}</td>
                            <td>{{ $plan->interval }}</td>
                            <td>{{ $plan->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ route('admin.plans.edit', $plan) }}" class="text-blue-500">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection