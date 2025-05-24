<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Models\JumlahTagihan;
use App\Http\Controllers\Controller;
use App\Models\AkunPembayaran;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{

    public function getTagihanByQrCode($qrcode)
    {
        $user = User::where('telepon', $qrcode)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        $tagihan = Tagihan::where('id_pelanggan', $user->id)
            ->whereIn('status', ['belum lunas', 'menunggu'])
            ->get();

        if ($tagihan->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tagihan yang belum lunas atau masih menunggu untuk pengguna ini'
            ], 404);
        }

        $tagihanData = $tagihan->map(function ($tagihanItem) use ($user) {
            return [
                'id' => $tagihanItem->id,
                'jumlah_tagihan' => $tagihanItem->jumlah_tagihan,
                'status' => $tagihanItem->status,
                'bukti_pembayaran' => $tagihanItem->bukti_pembayaran,
                'pelanggan' => [
                    'nama_lengkap' => $user->nama_lengkap,
                    'alamat' => $user->alamat,
                    'rt_rw' => $user->rt_rw,
                    'telepon' => $user->telepon,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Tagihan ditemukan',
            'data' => $tagihanData
        ], 200);
    }

    public function getUserPendingBills()
    {
        $user = auth()->user();
        $akunPembayaran = AkunPembayaran::find(1);

        if ($user->role === 'petugas') {
            $tagihan = Tagihan::with(['pelanggan'])
                ->where('status', '<>', 'lunas')
                ->get();
        } elseif ($user->role === 'pelanggan') {
            $tagihan = Tagihan::with(['pelanggan'])
                ->where('id_pelanggan', $user->id)
                ->where('status', '<>', 'lunas')
                ->get();
        } else {
            $tagihan = [];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'tagihan' => $tagihan,
                'akun_pembayaran' => $akunPembayaran
            ]
        ]);
    }

    public function getUserPaidBills()
    {
        $user = auth()->user();

        if ($user->role === 'petugas') {
            $tagihan = Tagihan::with(['pelanggan'])->get();
        } elseif ($user->role === 'pelanggan') {
            $tagihan = Tagihan::with(['pelanggan'])
                ->where('id_pelanggan', $user->id)
                ->get();
        } else {
            $tagihan = [];
        }

        return response()->json([
            'status' => 'success',
            'data' => $tagihan,
        ]);
    }

    public function bayarTagihan(Request $request, $id)
    {
        $tagihan = Tagihan::find($id);

        if (!$tagihan) {
            return response()->json(['message' => 'Tagihan tidak ditemukan'], 404);
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filePath = $file->store('bukti_pembayaran', 'public');
            $tagihan->bukti_pembayaran = $filePath;
        }

        $tagihan->metode_pembayaran = 'transfer';
        $tagihan->status = 'menunggu';
        $tagihan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil, menunggu konfirmasi'
        ], 200);
    }

    public function confirmCashPayment($id)
    {
        $tagihan = Tagihan::find($id);

        if (!$tagihan) {
            return response()->json(['message' => 'Tagihan tidak ditemukan'], 404);
        }

        $tagihan->status = 'lunas';
        $tagihan->metode_pembayaran = 'tunai';
        $tagihan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran cash berhasil diproses',
        ], 200);
    }

    public function konfirmasiPembayaran($tagihanId)
    {
        try {
            $tagihan = Tagihan::findOrFail($tagihanId);

            if ($tagihan->status === 'lunas') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tagihan sudah lunas.',
                ], 400);
            }

            $tagihan->status = 'lunas';
            $tagihan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil, status tagihan diperbarui menjadi lunas.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateJumlahTagihan(Request $request)
    {
        $validated = $request->validate([
            'jumlah_tagihan' => 'required|numeric',
        ]);

        $jumlahTagihan = JumlahTagihan::find(1);
        if ($jumlahTagihan) {
            $jumlahTagihan->update([
                'jumlah_tagihan' => $validated['jumlah_tagihan'],
            ]);
        }

        return redirect()->route('tagihan')->with('success', 'Jumlah tagihan berhasil diperbarui');
    }

    public function updateAkunPembayaran(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => 'required',
            'nama_pemilik' => 'required',
            'nomor_rekening' => 'required',
        ]);

        $akunPembayaran = AkunPembayaran::find(1);
        if ($akunPembayaran) {
            $akunPembayaran->update([
                'nama_bank' => $validated['nama_bank'],
                'nama_pemilik' => $validated['nama_pemilik'],
                'nomor_rekening' => $validated['nomor_rekening'],
            ]);
        }

        return redirect()->route('tagihan')->with('success', 'Jumlah tagihan berhasil diperbarui');
    }

    // public function index()
    // {
    //     $jumlahTagihan = JumlahTagihan::find(1);

    //     $akunPembayaran = AkunPembayaran::find(1);

    //     $tagihans = Tagihan::with('pelanggan')->get();

    //     $groupedTagihans = $tagihans->groupBy(function ($date) {
    //         return Carbon::parse($date->created_at)->format('d/m/Y');
    //     });

    //     $dataTagihan = [];

    //     foreach ($groupedTagihans as $key => $group) {
    //         $totalPelanggan = $group->count();

    //         $pelangganLunas = $group->where('status', 'lunas')->count();

    //         $pelangganBelumLunas = $group->whereIn('status', ['menunggu', 'belum lunas'])->count();

    //         $jumlahTagihanDetail = $group->sum('jumlah_tagihan');

    //         $dataTagihan[] = [
    //             'tanggal' => $key,
    //             'jumlah_tagihan' => $jumlahTagihanDetail,
    //             'total_pelanggan' => $totalPelanggan,
    //             'pelanggan_lunas' => $pelangganLunas,
    //             'pelanggan_belum_lunas' => $pelangganBelumLunas,
    //         ];
    //     }

    //     return view('tagihan', compact('jumlahTagihan', 'dataTagihan', 'akunPembayaran'));
    // }

    public function index()
    {
        $dataTagihan = Tagihan::with('pelanggan')
            ->where('status', '<>', 'lunas')
            ->get();
        $jumlahTagihan = JumlahTagihan::find(1);
        $akunPembayaran = AkunPembayaran::find(1);

        return view('tagihan', compact('dataTagihan', 'jumlahTagihan', 'akunPembayaran'));
    }

    public function konfirmasiPembayaranCash($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        $tagihan->status = 'lunas';

        if ($tagihan->metode_pembayaran !== 'transfer') {
            $tagihan->metode_pembayaran = 'tunai';
        }

        $tagihan->save();

        return redirect()->route('tagihan')->with('success', 'Tagihan berhasil dikonfirmasi sebagai lunas.');
    }


    public function searchTagihan(Request $request)
    {
        $user = auth()->user();
        $query = $request->get('query');

        if ($user->role === 'petugas') {
            $tagihan = Tagihan::with('pelanggan')
                ->whereIn('status', ['belum lunas', 'menunggu'])
                ->whereHas('pelanggan', function ($q) use ($query) {
                    $q->where('nama_lengkap', 'LIKE', "%{$query}%")
                        ->orWhere('telepon', 'LIKE', "%{$query}%");
                })
                ->orWhere('id', 'LIKE', "%{$query}%")
                ->where('status', '<>', 'lunas')
                ->get();

            // Logika untuk role 'pelanggan'
        } elseif ($user->role === 'pelanggan') {
            $tagihan = Tagihan::with('pelanggan')
                ->where('id_pelanggan', $user->id)
                ->whereIn('status', ['belum lunas', 'menunggu'])
                ->whereHas('pelanggan', function ($q) use ($query) {
                    $q->where('nama_lengkap', 'LIKE', "%{$query}%")
                        ->orWhere('telepon', 'LIKE', "%{$query}%");
                })
                ->orWhere('id', 'LIKE', "%{$query}%")
                ->where('status', '<>', 'lunas')
                ->get();
        } else {
            $tagihan = [];
        }

        return response()->json([
            'status' => 'success',
            'data' => $tagihan,
        ]);
    }
}
