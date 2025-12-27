<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

echo "--- Starting Verification ---\n";

// 1. Storage Check
try {
    echo "Testing Storage Write... ";
    Storage::disk('local')->put('verification_test.txt', 'Verified');
    if (Storage::disk('local')->exists('verification_test.txt')) {
        Storage::disk('local')->delete('verification_test.txt');
        echo "OK (Write/Delete successful)\n";
    } else {
        echo "FAILED (File not found after write)\n";
    }
} catch (\Throwable $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}

// 2. Logging Check
try {
    echo "Testing Log Write... ";
    Log::info('Verification script running.');
    // Check if log file exists/updated? Hard to check specifically, but if no exception, good.
    echo "OK (Log::info executed)\n";
} catch (\Throwable $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}

// 3. Dependency Check (Cashier class existence)
echo "Testing Laravel Cashier... ";
if (class_exists(\Laravel\Cashier\Cashier::class)) {
    echo "OK (Class found)\n";
} else {
    echo "FAILED (Cashier class missing)\n";
}

echo "--- Verification Complete ---\n";
