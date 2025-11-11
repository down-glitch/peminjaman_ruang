<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalRegulerTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_reguler', function (Blueprint $table) {
            $table->id('id_reguler');

            // relasi ke tabel rooms
            $table->unsignedBigInteger('id_room');

            // hari dan jam
            $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('deskripsi')->nullable();
            $table->index(['id_room']);
            $table->timestamps();

            // foreign key ke tabel rooms (pastikan tabel rooms sudah ada)
            $table->foreign('id_room')->references('id_room')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_reguler', function (Blueprint $table) {
            $table->dropForeign(['id_room']);
        });

        Schema::dropIfExists('jadwal_reguler');
    }
}

