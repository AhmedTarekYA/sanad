<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('client_reviews_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_review_id')->constrained('client_reviews')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->string('name');
            $table->string('job')->nullable();
            $table->string('company_name')->nullable();
            $table->text('review_message');
            $table->unique(['client_review_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_reviews_translations');
        Schema::dropIfExists('client_reviews');
    }
};
