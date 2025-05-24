<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Fungsi untuk menampilkan dashboard utama
    public function index()
    {
        // Menghitung total pengguna dalam sistem
        $totalUsers = User::count();

        // Menghitung total pendapatan bulan ini dari tagihan yang berstatus "lunas"
        $totalRevenueThisMonth = Tagihan::where('status', 'lunas')
            ->whereMonth('created_at', date('m')) // Filter berdasarkan bulan saat ini
            ->sum('jumlah_tagihan'); // Mengambil total jumlah tagihan langsung dari tabel Tagihan

        // Menghitung total pendapatan keseluruhan dari tagihan yang berstatus "lunas"
        $totalRevenue = Tagihan::where('status', 'lunas')
            ->sum('jumlah_tagihan'); // Mengambil total jumlah tagihan langsung dari tabel Tagihan

        // Menghitung jumlah tagihan yang belum lunas atau masih menunggu pada bulan ini
        $unpaidBillsThisMonth = Tagihan::whereIn('status', ['belum lunas', 'menunggu'])
            ->whereMonth('created_at', date('m')) // Filter berdasarkan bulan saat ini
            ->count(); // Menghitung jumlah tagihan yang belum lunas

        // Menghitung total pendapatan per bulan
        $revenuePerMonth = Tagihan::select(DB::raw('MONTH(created_at) as month, SUM(jumlah_tagihan) as revenue'))
            ->groupBy(DB::raw('MONTH(created_at)')) // Mengelompokkan berdasarkan bulan
            ->orderBy('month', 'ASC') // Mengurutkan berdasarkan bulan secara ascending
            ->get(); // Mengambil hasil query

        // Menampilkan dashboard dengan data yang sudah dikumpulkan
        return view('dashboard', [
            'totalUsers' => $totalUsers, // Mengirim total pengguna
            'totalRevenueThisMonth' => $totalRevenueThisMonth, // Mengirim total pendapatan bulan ini
            'unpaidBillsThisMonth' => $unpaidBillsThisMonth, // Mengirim jumlah tagihan yang belum lunas bulan ini
            'totalRevenue' => $totalRevenue, // Mengirim total pendapatan keseluruhan
            'revenuePerMonth' => $revenuePerMonth, // Mengirim data pendapatan per bulan
        ]);
    }
}