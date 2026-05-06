<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('packages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        $table->string('nama_paket');
        $table->string('slug')->unique();
        $table->decimal('harga', 15, 2);
        $table->text('deskripsi_paket');
        $table->string('gambar_utama');
        $table->timestamps();
    });
}
};
