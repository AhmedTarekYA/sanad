<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_user_id')->constrained('crm_users')->cascadeOnDelete();
            $table->foreignId('whatsapp_business_setting_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->index();
            $table->string('type')->default('immediate')->index();
            $table->text('message_body')->nullable();
            $table->string('template_name')->nullable();
            $table->string('template_language')->nullable();
            $table->json('button_quick_reply_ids')->nullable();
            $table->timestamp('scheduled_at')->nullable()->index();
            $table->string('status')->default('draft')->index();
            $table->timestamp('sent_at')->nullable()->index();
            $table->unsignedInteger('audience_count')->default(0);
            $table->unsignedInteger('delivered_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_broadcasts');
    }
};
