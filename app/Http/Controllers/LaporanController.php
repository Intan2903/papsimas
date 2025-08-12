<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TagihanExport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Fungsi untuk menampilkan halaman laporan
    public function index(Request $request)
    {
        // Query untuk mengambil data tagihan yang berstatus "lunas" dan memuat relasi dengan pelanggan
        $tagihansQuery = Tagihan::where('status', 'lunas')->with('pelanggan');

        // Mengambil daftar bulan dan tahun dari tagihan yang berstatus "lunas"
        $availableMonths = Tagihan::where('status', 'lunas')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month') // Mengambil tahun dan bulan
            ->groupBy('year', 'month') // Mengelompokkan berdasarkan tahun dan bulan
            ->orderBy('year', 'desc') // Mengurutkan berdasarkan tahun (terbaru ke terlama)
            ->orderBy('month', 'desc') // Mengurutkan berdasarkan bulan (terbaru ke terlama)
            ->get();

        // Mengambil daftar tahun unik dari data tagihan
        $availableYears = $availableMonths->unique('year');

        // Jika filter bulan dan tahun diisi, tambahkan kondisi pada query
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $tagihansQuery->whereYear('created_at', $tahun) // Filter berdasarkan tahun
                ->whereMonth('created_at', $bulan); // Filter berdasarkan bulan
        }
//nama intan//
        // Eksekusi query dan ambil hasilnya
        $tagihans = $tagihansQuery->get();

        // Kirimkan data ke tampilan laporan
        return view('laporan', compact('tagihans', 'availableYears', 'availableMonths'));
    }

    // Fungsi untuk mengekspor laporan ke dalam format Excel
    public function exportExcel(Request $request)
    {
        // Query untuk mengambil data tagihan yang berstatus "lunas" dan memuat relasi dengan pelanggan
        $tagihansQuery = Tagihan::where('status', 'lunas')->with('pelanggan');

        // Jika filter bulan dan tahun diisi, tambahkan kondisi pada query
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $tagihansQuery->whereYear('created_at', $tahun) // Filter berdasarkan tahun
                ->whereMonth('created_at', $bulan); // Filter berdasarkan bulan
        }

        // Eksekusi query dan ambil hasilnya
        $tagihans = $tagihansQuery->get();

        // Mengekspor data ke file Excel dengan nama "laporan_tagihan_lunas.xlsx"
        return Excel::download(new TagihanExport($tagihans), 'laporan_tagihan_lunas.xlsx');
    }
}