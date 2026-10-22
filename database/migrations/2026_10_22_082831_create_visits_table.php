<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device', 20)->default('desktop'); // mobile, tablet, desktop
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('url', 500)->nullable();
            $table->string('referer', 500)->nullable();
            $table->string('session_id', 100)->nullable();
            $table->boolean('is_unique')->default(false); // first visit this session
            $table->timestamp('created_at')->useCurrent();
            $table->index(['created_at']);
            $table->index(['ip']);
            $table->index(['device']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
