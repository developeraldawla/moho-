@extends('layouts.app')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">AI Tools Library</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Explore our collection of powerful AI tools designed to help you analyze, optimize, and scale.
            </p>
        </div>

        <!-- Category Tabs (Simplified for now) -->
        <div class="flex flex-wrap justify-center gap-2">
            <button class="px-4 py-2 rounded-full bg-primary-600 text-white font-medium shadow-md">All Tools</button>
            @foreach($tools->keys() as $category)
                <button
                    class="px-4 py-2 rounded-full bg-white dark:bg-dark-card text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors">
                    {{ ucfirst($category) }}
                </button>
            @endforeach
        </div>

        <!-- Tools Grid -->
        @foreach($tools as $category => $categoryTools)
            <div class="mb-12">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-l-4 border-primary-500 pl-4">
                    {{ ucfirst($category) }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($categoryTools as $tool)
                        <div
                            class="group flex flex-col bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-primary-500 hover:shadow-xl transition-all duration-300">
                            <div class="p-6 flex flex-col flex-1">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform duration-300 group-hover:bg-primary-50 dark:group-hover:bg-primary-900/20">
                                    {{ $tool->icon ?? '🛠️' }}
                                </div>

                                <h3
                                    class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 transition-colors">
                                    {{ app()->getLocale() == 'tr' ? $tool->name_tr : $tool->name_en }}
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex-1 line-clamp-3">
                                    {{ app()->getLocale() == 'tr' ? $tool->description_tr : $tool->description_en }}
                                </p>

                                <div class="mt-auto flex items-center justify-between">
                                    <span
                                        class="text-xs font-medium px-2 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                        {{ $tool->daily_limit_default }} credits/day
                                    </span>
                                    @if($tool->is_premium)
                                        <span class="text-xs font-bold text-amber-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Premium
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('tools.show', $tool->id) }}"
                                class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 rounded-b-2xl text-center text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                Use Tool &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection