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
       Schema::create('petugas', function (Blueprint $table) {
    $table->id('id_petugas');
    $table->string('nama_petugas');
    $table->string('jenis_kelamin');
    $table->date('tanggal_lahir');
    $table->text('alamat');
    $table->enum('is_active', ['active', 'nonactive'])->default('active');
   $table->string('email')->unique();
   $table->string('image')->nullable();

    $table->foreignId('id_user')
      ->references('id_user')
      ->on('users')
      ->onDelete('cascade');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
