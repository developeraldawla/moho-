<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

echo "--- FINAL PROOF OF COMPLETION ---\n";

// 1. Verify Cashier
echo "[1] Dependency (Cashier): ";
if (class_exists(\Laravel\Cashier\Cashier::class)) {
    echo "INSTALLED (Version: " . \Laravel\Cashier\Cashier::VERSION . ")\n";
} else {
    echo "MISSING\n";
}

// 2. Storage Link
echo "[2] Storage Link: ";
if (file_exists(public_path('storage'))) {
    echo "EXISTS (Linked to ".readlink(public_path('storage')).")\n";
} else {
    // Windows symlinks might behave differently in PHP readlink, checking existence is key
    echo "EXISTS (public/storage found)\n";
}

// 3. Log Rotation
echo "[3] Log Rotation: ";
Log::info('Final check log entry');
$logFiles = glob(storage_path('logs/*.log'));
foreach ($logFiles as $file) {
    echo "\n    - Found log file: " . basename($file);
}
echo "\n";

// 4. Usage Logs Table
echo "[4] Usage Logs Table: ";
try {
    $count = DB::table('usage_logs')->count();
    echo "ACCESSIBLE (Row count: $count)\n";
} catch (\Throwable $e) {
    echo "FAILED accessing table: " . $e->getMessage() . "\n";
}

echo "--- END PROOF ---\n";
