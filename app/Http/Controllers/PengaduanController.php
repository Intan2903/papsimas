<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    /**
     * Menampilkan daftar pengaduan berdasarkan peran pengguna.
     * - Jika pengguna adalah pelanggan, hanya menampilkan pengaduan miliknya.
     * - Jika pengguna adalah admin/petugas, menampilkan semua pengaduan.
     */
    public function index()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        $role = $user->role;  // Mendapatkan peran pengguna

        if ($role == 'pelanggan') {
            // Pelanggan hanya bisa melihat pengaduannya sendiri
            $pengaduan = Pengaduan::where('id_pengguna', $user->id)->get();
        } else {
            // Admin atau petugas bisa melihat semua pengaduan
            $pengaduan = Pengaduan::all();
        }

        return response()->json($pengaduan);
    }

    /**
     * Menyimpan pengaduan baru dari pengguna.
     * - Hanya menerima input 'isi' dari request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string', // Validasi input
        ]);

        // Membuat pengaduan baru
        $pengaduan = Pengaduan::create([
            'id_pengguna' => Auth::id(),
            'isi' => $request->isi,
            'balasan' => null, // Awalnya belum ada balasan
        ]);

        return response()->json(['message' => 'Pengaduan berhasil dikirim', 'pengaduan' => $pengaduan], 201);
    }

    /**
     * Menambahkan atau memperbarui balasan pengaduan melalui mobile API.
     */
    public function updateBalasanMobile(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required|string', // Validasi input
        ]);

        $pengaduan = Pengaduan::findOrFail($id); // Mencari pengaduan berdasarkan ID
        $pengaduan->balasan = $request->balasan; // Menyimpan balasan
        $pengaduan->save();

        return response()->json(['message' => 'Balasan berhasil ditambahkan.', 'pengaduan' => $pengaduan]);
    }

    /**
     * Menampilkan daftar pengaduan di halaman web dengan pagination.
     */
    public function showPengaduan()
    {
        $pengaduan = Pengaduan::with('pengguna')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu terbaru
            ->paginate(10); // Batasi 10 per halaman

        return view('pengaduan', compact('pengaduan'));
    }

    /**
     * Menampilkan detail pengaduan berdasarkan ID.
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with('pengguna')->findOrFail($id);
        return view('pengaduan_detail', compact('pengaduan'));
    }

    /**
     * Menambahkan atau memperbarui balasan pengaduan melalui web.
     */
    public function updateBalasan(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required|string', // Validasi input
        ]);

        $pengaduan = Pengaduan::findOrFail($id); // Mencari pengaduan berdasarkan ID
        $pengaduan->balasan = $request->balasan; // Simpan balasan
        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Balasan berhasil ditambahkan.');
    }
}