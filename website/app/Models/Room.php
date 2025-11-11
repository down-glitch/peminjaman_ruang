<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id_room'; // kalau PK bukan 'id'
    protected $fillable = ['nama_room', 'lokasi', 'kapasitas', 'deskripsi'];
}
