<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'nama_petugas',
        'telepon',
        'tanggal_lahir',
        'user_login_id',
    ];

    // Relasi ke UserLogin
    public function userLogin()
    {
        return $this->belongsTo(UserLogin::class, 'user_login_id', 'id');
    }
}
