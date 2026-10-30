<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_choose_us', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('why_choose_us_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('why_choose_us_id')->constrained('why_choose_us')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->unique(['why_choose_us_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_us_translations');
        Schema::dropIfExists('why_choose_us');
    }
};
