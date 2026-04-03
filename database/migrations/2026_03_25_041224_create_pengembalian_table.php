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
       Schema::create('pengembalian', function (Blueprint $table) {
    $table->id('id_pengembalian');

    $table->unsignedBigInteger('id_peminjaman');
    $table->unsignedBigInteger('id_petugas');

    $table->date('tanggal_kembali');
    $table->integer('denda')->default(0);

     $table->enum('status', ['tepat_waktu', 'terlambat'])
          ->default('tepat_waktu');

    $table->timestamps();

    $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');
    $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
