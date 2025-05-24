<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahTagihan extends Model
{
    use HasFactory;

    protected $table = 'jumlah_tagihan';

    protected $fillable = [
        'jumlah_tagihan'
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_jumlah_tagihan', 'id');
    }
}
