@extends('layouts.app')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                <p class="text-gray-500 dark:text-gray-400">Welcome back, {{ $user->name }}!</p>
            </div>
            <a href="{{ route('tools.index') }}"
                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors shadow">
                New Analysis
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Daily Usage</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $usageCount }} <span
                                class="text-sm font-normal text-gray-400">/ 10</span></p>
                    </div>
                </div>
                <div class="mt-4 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(($usageCount / 10) * 100, 100) }}%"></div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Saved Works</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $savedCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Trial Status</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $trialDaysLeft }} Days <span
                                class="text-sm font-normal text-gray-400">Left</span></p>
                    </div>
                </div>
                <a href="#" class="mt-3 block text-sm text-primary-600 hover:text-primary-700 font-medium">Upgrade to Pro
                    &rarr;</a>
            </div>
        </div>

        <!-- Recommended Tools -->
        <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recommended Tools</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recommendedTools as $tool)
                    <div
                        class="bg-white dark:bg-dark-card p-6 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-500 transition-colors group">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xl group-hover:bg-primary-50 dark:group-hover:bg-primary-900/20">
                                {{ $tool->icon ?? '⚡' }}
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                {{ $tool->category }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-1">
                            {{ app()->getLocale() == 'tr' ? $tool->name_tr : $tool->name_en }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">
                            {{ app()->getLocale() == 'tr' ? $tool->description_tr : $tool->description_en }}
                        </p>
                        <a href="{{ route('tools.show', $tool->id) }}"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-primary-700 bg-primary-100 hover:bg-primary-200 dark:bg-primary-900/30 dark:text-primary-300 dark:hover:bg-primary-900/50 transition-colors">
                            Use Tool
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection