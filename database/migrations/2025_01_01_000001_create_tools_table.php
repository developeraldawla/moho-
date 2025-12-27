<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_tr'); // Bilingual Support
            $table->text('description_en')->nullable();
            $table->text('description_tr')->nullable();
            $table->string('icon')->nullable();
            $table->string('category')->index(); // Product, Image, Data, Text
            $table->string('n8n_webhook_url')->nullable();
            $table->jsonb('input_fields')->default('[]'); // JSON Schema for Inputs
            $table->string('output_type')->default('text'); // text, image, file, excel_viz
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->integer('daily_limit_default')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
