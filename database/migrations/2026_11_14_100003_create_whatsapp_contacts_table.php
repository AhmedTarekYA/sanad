<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_user_id')->constrained('crm_users')->cascadeOnDelete();
            $table->string('wa_id')->index();
            $table->string('name')->nullable()->index();
            $table->string('profile_pic')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('source')->nullable()->index();
            $table->text('note')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamp('registered_at')->nullable()->index();
            $table->timestamp('last_activity')->nullable()->index();
            $table->timestamps();

            $table->unique(['crm_user_id', 'wa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_contacts');
    }
};
