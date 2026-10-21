<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_header')->default('logo_header.png');
            $table->string('logo_footer')->default('logo_footer.png');
            $table->string('favicon')->default('favicon.png');
            $table->string('twitter')->default('#');
            $table->string('facebook')->default('#');
            $table->string('instagram')->default('#');
            $table->string('snapchat')->default('#');
            $table->string('linkedin')->default('#');
            $table->string('youtube')->default('#');
            $table->string('whatsapp')->default('#');
            $table->string('email')->default('#');
            $table->string('phone')->default('#');
            $table->string('other_phone')->default('#');
            $table->string('fax_number')->default('#');
            $table->string('default_lang')->default('en');
            $table->string('map_link', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
