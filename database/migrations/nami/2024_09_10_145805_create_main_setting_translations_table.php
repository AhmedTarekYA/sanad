<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('main_setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_setting_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('sidebar_text');
            $table->string('copyright_text');
            $table->string('company_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_setting_translations');
    }
};
