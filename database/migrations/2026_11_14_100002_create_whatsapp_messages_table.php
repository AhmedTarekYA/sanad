<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('whatsapp_conversations')->cascadeOnDelete();
            $table->foreignId('crm_user_id')->constrained('crm_users')->cascadeOnDelete();
            $table->foreignId('whatsapp_business_setting_id')->nullable()->constrained()->nullOnDelete();
            $table->string('wamid')->nullable()->unique();
            $table->string('direction')->index();
            $table->string('from_wa_id')->nullable()->index();
            $table->string('to_wa_id')->nullable()->index();
            $table->string('type')->default('text');
            $table->string('message_status', 20)->nullable()->index();
            $table->text('body')->nullable();
            $table->timestamp('wa_timestamp')->nullable()->index();
            $table->json('raw')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
