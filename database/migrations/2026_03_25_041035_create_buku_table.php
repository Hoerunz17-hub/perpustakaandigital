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
       Schema::create('buku', function (Blueprint $table) {
    $table->id('id_buku');
    $table->string('kode_buku', 20)->unique();
    $table->string('judul_buku', 100);
    $table->string('penulis', 100);
    $table->date('tahun_terbit');
    $table->integer('stock');
    $table->string('kategori', 100);
    $table->enum('is_active', ['active', 'nonactive'])->default('active');
    $table->string('cover')->nullable();
    $table->text('deskripsi_buku');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
