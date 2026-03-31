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
       Schema::create('kepala_perpustakaan', function (Blueprint $table) {
    $table->id('id_kepala');
    $table->string('nama_kepala', 100);
    $table->string('jenis_kelamin', 100);
    $table->date('tanggal_lahir');
    $table->text('alamat');
    $table->string('email')->unique();

    // $table->foreignId('id_user')
    //       ->constrained('users', 'id_user')
    //       ->onDelete('cascade');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepala_perpustakaan');
    }
};
