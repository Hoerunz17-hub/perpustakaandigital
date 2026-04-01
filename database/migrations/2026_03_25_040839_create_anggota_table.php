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
       Schema::create('anggota', function (Blueprint $table) {
    $table->id('id_anggota');
    $table->string('nama_anggota');
    $table->string('jenis_kelamin');
    $table->date('tanggal_lahir');
    $table->text('alamat');
    $table->string('email')->unique();
    $table->string('image')->nullable();
    $table->integer('max_pinjam')->default(3);

    $table->foreignId('id_user')
          ->constrained('users', 'id_user')
          ->onDelete('cascade');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
