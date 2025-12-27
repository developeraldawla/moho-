<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, warning, error, success
            $table->boolean('is_active')->default(true);
            $table->timestamp('show_from')->nullable();
            $table->timestamp('show_until')->nullable();
            $table->integer('priority')->default(0);
            $table->string('action_url')->nullable();
            $table->string('action_text')->nullable();
            $table->timestamps();
        });

        Schema::create('banner_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('dismissed_at')->useCurrent();

            $table->unique(['banner_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_reads');
        Schema::dropIfExists('banners');
    }
};
