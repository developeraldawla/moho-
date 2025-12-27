<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedWorkController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.auth');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tools', [ToolController::class, 'index'])->name('tools');
    Route::get('/tools/{tool}', [ToolController::class, 'show'])->name('tools.show');
    Route::post('/tools/{tool}/use', [ToolController::class, 'useTool'])->name('tools.use');
    Route::get('/saved', [SavedWorkController::class, 'index'])->name('saved');
    Route::delete('/saved/{savedWork}', [SavedWorkController::class, 'destroy'])->name('saved.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});

Route::middleware(['auth', 'subscription', 'throttle:tool_usage'])->group(function () {
    Route::post('/tools/{tool}/execute', [ToolController::class, 'execute'])->name('tools.execute');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/plans', PlansController::class);
    Route::resource('/banners', BannersController::class);
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});

Route::post('/webhook/stripe', [WebhookController::class, 'handleStripe'])->name('webhook.stripe');

require __DIR__ . '/auth.php';

// Health Check Endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'database' => \Illuminate\Support\Facades\DB::connection()->getPdo() ? 'connected' : 'failed',
        'timestamp' => now()->toIso8601String(),
    ]);
});
