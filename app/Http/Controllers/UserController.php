<?php

namespace App\Http\Controllers;

use App\Models\User;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\Image\Png;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('telepon', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:255',
            'telepon' => 'nullable|max:15',
            'alamat' => 'required',
            'rt_rw' => 'required',
            'status' => 'nullable',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $renderer = new Png();
        $renderer->setWidth(200);
        $renderer->setHeight(200);

        $writer = new Writer($renderer);
        $qrcodeData = $request->telepon;

        $path = public_path('qrcodes/');
        if (!file_exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        $filename = 'qrcode_' . time() . '.png';
        $qrcodePath = $path . $filename;

        $writer->writeFile($qrcodeData, $qrcodePath);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'rt_rw' => $request->rt_rw,
            'status' => 'aktif',
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'qrcode' => $filename,
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required',
            'role' => 'required',
        ]);

        $user->update([
            'status' => $request->status,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'rt_rw' => 'required|string|max:10',
        ]);

        $user = Auth::user();
        $user->update([
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'rt_rw' => $request->rt_rw,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
