<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\JumlahTagihan;

class AddMonthlyBill extends Command
{
    protected $signature = 'add:monthly-bill';
    protected $description = 'Menambahkan tagihan otomatis setiap bulan untuk pelanggan dengan status aktif';

    public function handle()
    {
        $pelanggan = User::where('role', 'pelanggan')->where('status', 'aktif')->get();

        $jumlahTagihan = JumlahTagihan::find(1);

        if (!$jumlahTagihan) {
            $this->error('Jumlah tagihan dengan ID 1 tidak ditemukan!');
            return;
        }

        foreach ($pelanggan as $user) {
            Tagihan::create([
                'id_pelanggan' => $user->id,
                'id_jumlah_tagihan' => $jumlahTagihan->id,
                'jumlah_tagihan' => $jumlahTagihan->jumlah_tagihan,
                'status' => 'belum lunas'
            ]);
        }

        $this->info('Tagihan bulan ini telah ditambahkan untuk semua pelanggan aktif.');
    }
}
