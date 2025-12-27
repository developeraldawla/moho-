<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->jsonb('input_data')->nullable(); // Store inputs for retry/debug
            $table->jsonb('output_data')->nullable(); // Store quick reference result or status
            $table->string('status')->default('success'); // success, error
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']); // For daily limit checks
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_logs');
    }
};
