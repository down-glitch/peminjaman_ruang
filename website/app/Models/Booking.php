<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';
    protected $primaryKey = 'id_booking';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; // pastikan aktif jika tabel memiliki kolom created_at & updated_at

    protected $fillable = [
        'user_id',
        'id_room',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'keterangan',
    ];

    /**
     * Relasi ke tabel users (user_login)
     */
    public function user()
    {
        // ✅ disarankan pakai model User (bukan UserLogin)
        // tapi kalau kamu memang pakai UserLogin, tetap oke — pastikan model itu ada.
        return $this->belongsTo(UserLogin::class, 'user_id', 'id');
    }

    /**
     * Relasi ke tabel rooms
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room', 'id_room');
    }
}
