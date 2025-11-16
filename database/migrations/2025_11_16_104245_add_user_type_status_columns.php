<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Cek jika kolom belum ada, lalu tambahkan
        if (!Schema::hasColumn('users', 'type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('type', ['standard', 'advance', 'admin'])->default('standard')->after('email');
            });
        }

        if (!Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('type');
            });
        }

        // Update user yang sudah ada untuk memiliki nilai default
        DB::table('users')->whereNull('type')->update(['type' => 'standard']);
        DB::table('users')->whereNull('status')->update(['status' => 'active']);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']);
        });
    }
};