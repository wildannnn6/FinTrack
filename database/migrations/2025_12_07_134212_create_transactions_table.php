<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->enum('type', ['income', 'expense']);
            $table->unsignedBigInteger('amount'); // Jumlah transaksi
            $table->string('category');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
