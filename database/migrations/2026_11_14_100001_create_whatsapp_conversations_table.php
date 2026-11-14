<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_user_id')->constrained('crm_users')->cascadeOnDelete();
            $table->foreignId('whatsapp_business_setting_id')->nullable()->constrained()->nullOnDelete();
            $table->string('wa_id')->index();
            $table->string('display_name')->nullable();
            $table->string('status')->default('open')->index();
            $table->timestamp('resolved_at')->nullable()->index();
            $table->unsignedInteger('unread_count')->default(0);
            $table->timestamp('last_message_at')->nullable()->index();
            $table->timestamps();

            $table->unique(['crm_user_id', 'wa_id', 'whatsapp_business_setting_id'], 'wa_conv_user_wa_setting_unique');
            $table->index(['whatsapp_business_setting_id', 'last_message_at'], 'wa_conv_setting_last_msg_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_conversations');
    }
};
