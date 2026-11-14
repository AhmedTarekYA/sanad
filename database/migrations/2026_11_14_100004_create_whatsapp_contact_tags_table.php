<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_contact_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_user_id')->constrained('crm_users')->cascadeOnDelete();
            $table->string('name');
            $table->string('color')->nullable();
            $table->timestamps();

            $table->unique(['crm_user_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_contact_tags');
    }
};
