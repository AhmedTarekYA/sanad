<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_business_hours_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_user_id')->constrained('crm_users')->cascadeOnDelete();
            $table->string('timezone')->nullable();
            $table->boolean('business_hours_enabled')->default(false)->index();
            $table->json('hours')->nullable();
            $table->boolean('away_message_enabled')->default(false)->index();
            $table->text('away_message')->nullable();
            $table->timestamps();

            $table->unique('crm_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_business_hours_settings');
    }
};
