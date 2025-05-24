<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'id_pengguna', 'isi', 'balasan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}
