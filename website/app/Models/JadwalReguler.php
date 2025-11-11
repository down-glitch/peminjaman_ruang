<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalReguler extends Model
{
    use HasFactory;

    protected $table = 'jadwal_reguler';
    protected $primaryKey = 'id_reguler';
    public $timestamps = true;

    protected $fillable = [
        'id_room',
        'id_kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'deskripsi',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room', 'id_room');
    }
}
