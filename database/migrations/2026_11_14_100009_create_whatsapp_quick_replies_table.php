<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_quick_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_user_id')->constrained('crm_users')->cascadeOnDelete();
            $table->string('title')->index();
            $table->string('shortcut')->nullable()->index();
            $table->text('body');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_quick_replies');
    }
};
