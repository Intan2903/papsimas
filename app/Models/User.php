<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'nama_lengkap',
        'telepon',
        'alamat',
        'rt_rw',
        'qrcode',
        'status', // aktif, nonaktif
        'password',
        'role' // admin, petugas, pelanggan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_pelanggan');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_pengguna');
    }
}
