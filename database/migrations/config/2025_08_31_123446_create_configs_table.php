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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            // App Mode
            $table->integer('is_dev')->default(0);
            $table->integer('is_maintenance')->default(0);
            $table->integer('force_update')->default(0);
            $table->integer('show_dialog')->default(0);

            // Update
            $table->string('latest_version_android')->nullable();
            $table->string('latest_version_ios')->nullable();

            // API
            $table->string('api_base_url')->nullable();
            $table->string('api_image_base_url')->nullable();

            // Features
            $table->integer('enable_payment')->default(0);

            // Messages
            $table->string('welcome_message')->nullable();
            $table->string('update_message')->nullable();
            $table->string('maintenance_message')->nullable();
            $table->string('force_update_message')->nullable();

            // Integrations
            $table->string('maps_api_key')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
