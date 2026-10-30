<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_choose_us_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('why_choose_us_id')->constrained('why_choose_us')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('why_choose_us_feature_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('why_choose_us_feature_id');
            $table->string('locale', 10);
            $table->string('title');
            $table->text('description')->nullable();
            $table->unique(['why_choose_us_feature_id', 'locale'], 'wcu_feature_translations_unique');
            $table->foreign('why_choose_us_feature_id', 'wcu_feature_translations_feature_fk')
                ->references('id')
                ->on('why_choose_us_features')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_us_feature_translations');
        Schema::dropIfExists('why_choose_us_features');
    }
};
