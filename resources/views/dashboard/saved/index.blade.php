@extends('layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">My Saved Works</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($works as $work)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="font-bold text-lg mb-2">{{ $work->title }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $work->created_at->format('M d, Y') }}</p>
                    <div class="flex justify-between items-center">
                        <a href="#" class="text-blue-600">View</a>
                        <form action="{{ route('saved.works.destroy', $work->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $works->links() }}
        </div>
    </div>
@endsection