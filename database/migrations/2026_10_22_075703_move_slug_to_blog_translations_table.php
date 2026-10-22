<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_translations', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('locale');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('is_featured');
        });

        Schema::table('blog_translations', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
