<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Moho')); ?> - <?php echo $__env->yieldContent('title', 'AI Platform'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="font-sans antialiased text-gray-900 bg-white dark:bg-dark-bg dark:text-dark-text" x-data
    x-init="$store.darkMode.init()">

    <!-- Header -->
    <header
        class="fixed w-full z-50 bg-white/80 dark:bg-dark-bg/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo e(route('home')); ?>"
                        class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-indigo-600">
                        moho
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <?php $__currentLoopData = ['features', 'tools', 'pricing', 'faq']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="#<?php echo e($item); ?>"
                            class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-white transition-colors capitalize font-medium">
                            <?php echo e(__($item)); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            <?php echo e(strtoupper(app()->getLocale())); ?>

                        </button>
                        <!-- Dropdown would go here -->
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button @click="$store.darkMode.toggle()"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg x-show="!$store.darkMode.on" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24"
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

                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>"
                            class="text-sm font-semibold text-gray-900 dark:text-white hover:text-primary-600">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>"
                            class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900">Log
                            in</a>
                        <a href="<?php echo e(route('register')); ?>"
                            class="px-5 py-2.5 rounded-full bg-primary-600 hover:bg-primary-700 text-white font-medium text-sm transition-all shadow-lg hover:shadow-primary-500/30">
                            Start Free Trial
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-20">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-dark-card border-t border-gray-200 dark:border-gray-800 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">moho</span>
                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                        Analyze, Optimize, and Scale your business with powerful AI tools.
                    </p>
                </div>
                <!-- Links Columns -->
                <?php $__currentLoopData = ['Product' => ['Features', 'Pricing', 'API'], 'Company' => ['About', 'Blog', 'Careers'], 'Legal' => ['Privacy', 'Terms', 'Security']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title => $links): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4"><?php echo e($title); ?></h3>
                        <ul class="space-y-2">
                            <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="#"
                                        class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600"><?php echo e($link); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div
                class="border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-xs text-gray-400">&copy; <?php echo e(date('Y')); ?> Moho Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\aiman\Downloads\moho\moho\resources\views/layouts/guest.blade.php ENDPATH**/ ?>