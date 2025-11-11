<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->id('id_petugas');
            $table->string('nama_petugas', 50);
            $table->integer('telepon')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->unsignedBigInteger('user_login_id');
            $table->timestamps();
          
            $table->foreign('user_login_id')->references('id')->on('user_logins')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
