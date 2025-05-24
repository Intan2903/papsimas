<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'id_admin', 'judul', 'isi'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
