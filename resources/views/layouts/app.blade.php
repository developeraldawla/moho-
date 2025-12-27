<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Moho') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-gray-100"
    x-data="{ sidebarOpen: false }" x-init="$store.darkMode.init()">

    <!-- Sidebar Mobile -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" @click="sidebarOpen = false"></div>
        <div
            class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white dark:bg-dark-card transition ease-in-out duration-300 transform translate-x-0">
            <div class="flex-shrink-0 flex items-center px-4">
                <span class="text-2xl font-bold text-primary-600">moho</span>
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-2 space-y-1">
                    @include('layouts.navigation')
                </nav>
            </div>
        </div>
    </div>

    <!-- Static Sidebar Desktop -->
    <div
        class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-dark-card">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4 mb-8">
                <span
                    class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-indigo-600">moho</span>
            </div>
            <nav class="mt-5 flex-1 px-2 space-y-1">
                @include('layouts.navigation')
            </nav>
        </div>
        <div class="flex-shrink-0 flex border-t border-gray-200 dark:border-gray-800 p-4">
            <div class="flex items-center w-full">
                <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">View Profile</p>
                </div>
                <!-- Dark Mode Toggle Mini -->
                <button @click="$store.darkMode.toggle()" class="ml-auto p-1 text-gray-400 hover:text-gray-500">
                    <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="$store.darkMode.on" class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64 flex flex-col flex-1 min-h-screen">
        <div
            class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white dark:bg-dark-card border-b border-gray-200 dark:border-gray-800 lg:hidden">
            <button type="button"
                class="px-4 border-r border-gray-200 dark:border-gray-800 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden"
                @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>