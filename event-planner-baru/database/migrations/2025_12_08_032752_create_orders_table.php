<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->string('nama_pemesan');
            $table->string('email_pemesan')->nullable();
            $table->string('telepon_pemesan')->nullable();
            $table->date('tanggal_event');
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->integer('kode_unik'); // Misal: 123
            $table->decimal('total_bayar', 15, 2); // Harga Paket + 123
            $table->string('status_pembayaran')->default('pending'); // pending, success, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};