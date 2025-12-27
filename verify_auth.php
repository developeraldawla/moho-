<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking Authenticate Middleware...\n";
if (class_exists(\Illuminate\Auth\Middleware\Authenticate::class)) {
    echo "SUCCESS: Illuminate\Auth\Middleware\Authenticate exists.\n";
} else {
    echo "FAILURE: Class not found.\n";
}

try {
    $instance = new \App\Http\Middleware\Authenticate($app);
    echo "SUCCESS: App\Http\Middleware\Authenticate instantiated.\n";
} catch (\Throwable $e) {
    echo "FAILURE Instantiating: " . $e->getMessage() . "\n";
}
