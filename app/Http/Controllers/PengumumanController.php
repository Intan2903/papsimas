<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::paginate(10);

        return view('pengumuman', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        Pengumuman::create([
            'id_admin' => Auth::user()->id,
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('edit_pengumuman', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diupdate');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }
    
    public function fetchPengumuman()
    {
        $pengumuman = Pengumuman::all();

        return response()->json($pengumuman);
    }

    public function buatPengumuman(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $pengumuman = Pengumuman::create([
            'id_admin' => Auth::id(),
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
        ]);

        return response()->json([
            'message' => 'Pengumuman berhasil ditambahkan',
            'data' => $pengumuman
        ], 201);
    }
}
