<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'id_pelanggan',
        'id_jumlah_tagihan',
        'jumlah_tagihan',
        'metode_pembayaran', // transfet, tunai
        'status', // lunas, menunggu, belum lunas
        'bukti_pembayaran', // upload file
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    public function jumlahTagihan()
    {
        return $this->belongsTo(JumlahTagihan::class, 'id_jumlah_tagihan', 'id');
    }
}
