<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_broadcast_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broadcast_id')->constrained('whatsapp_broadcasts')->cascadeOnDelete();
            $table->string('wa_id')->index();
            $table->string('wamid')->nullable()->index();
            $table->string('status')->default('pending')->index();
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->unique(['broadcast_id', 'wa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_broadcast_recipients');
    }
};
