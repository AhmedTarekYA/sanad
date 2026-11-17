<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('role', ['admin', 'agent'])->default('agent')->after('password');
            $table->json('permissions')->nullable()->after('role');
        });

        DB::table('crm_users')->whereNull('role')->update(['role' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('crm_users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'permissions']);
        });
    }
};
