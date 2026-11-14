<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_contact_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('whatsapp_contacts')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('whatsapp_contact_tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['contact_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_contact_tag');
    }
};
