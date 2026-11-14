<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_conversation_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('whatsapp_conversations')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('whatsapp_chat_tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['conversation_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_conversation_tag');
    }
};
