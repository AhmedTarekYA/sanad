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
        Schema::table('main_settings', function (Blueprint $table) {
            $table->string('footer_logo')->after('loading_background_color')->nullable();
            $table->string('copyright_link')->after('footer_logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_settings', function (Blueprint $table) {
            $table->dropColumn('footer_logo');
            $table->dropColumn('copyright_link');
        });
    }
};
