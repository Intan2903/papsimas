<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TagihanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil tagihan dengan status lunas
        return Tagihan::where('status', 'lunas')
            ->with('pelanggan', 'jumlahTagihan')
            ->get()
            ->map(function ($tagihan) {
                return [
                    'Tanggal' => $tagihan->created_at->format('d/m/Y'),
                    'Nama Pelanggan' => $tagihan->pelanggan->nama_lengkap,
                    'Jumlah Tagihan' => 'Rp. ' . number_format($tagihan->jumlahTagihan->jumlah_tagihan, 0, ',', '.'),
                    'Tanggal Bayar' => $tagihan->updated_at->format('d/m/Y'),
                    'Metode Pembayaran' => $tagihan->metode_pembayaran,
                    'Bukti Pembayaran' => $tagihan->bukti_pembayaran ? asset('storage/' . $tagihan->bukti_pembayaran) : '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Pelanggan',
            'Jumlah Tagihan',
            'Tanggal Bayar',
            'Metode Pembayaran',
            'Bukti Pembayaran',
        ];
    }
}
