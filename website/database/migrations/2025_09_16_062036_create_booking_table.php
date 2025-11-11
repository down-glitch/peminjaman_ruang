<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id('id_booking');
            $table->unsignedBigInteger('user_id');   // relasi ke users
            $table->unsignedBigInteger('id_room');   // relasi ke rooms
            $table->date('tanggal');                 // tanggal booking
            $table->time('jam_mulai');               // jam mulai
            $table->time('jam_selesai');             // jam selesai
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable();  // opsional
            $table->timestamps();

            // relasi
            $table->foreign('user_id')->references('id')->on('user_logins')->onDelete('cascade');
            $table->foreign('id_room')->references('id_room')->on('rooms')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
