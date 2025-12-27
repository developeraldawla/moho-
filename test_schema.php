<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    echo "Running Schema Test...\n";
    if (Schema::hasTable('test_table')) {
        Schema::drop('test_table');
    }
    Schema::create('test_table', function(Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->dateTime('created_at')->nullable();
    });
    echo "Table 'test_table' created successfully.\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
