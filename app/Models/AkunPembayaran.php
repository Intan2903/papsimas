<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunPembayaran extends Model
{
    use HasFactory;

    protected $table = 'akun_pembayaran';

    protected $fillable = [
        'nama_bank', 'nama_pemilik', 'nomor_rekening'
    ];
}