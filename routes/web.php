<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PengumumanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$router->aliasMiddleware('role', CheckRole::class);

Route::resource('pengumuman', PengumumanController::class);

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/qrcodes/{filename}', [QRCodeController::class, 'show'])->name('qrcode.show');

Route::middleware(['role:admin'])->group(function () {
    Route::post('/tagihan/{tagihan}/konfirmasi', [TagihanController::class, 'konfirmasiPembayaranCash'])->name('tagihan.konfirmasi');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);

    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan');
    
    Route::put('/tagihan/update', [TagihanController::class, 'updateJumlahTagihan'])->name('tagihan.updateJumlah');
    
    Route::put('/pembayaran/update', [TagihanController::class, 'updateAkunPembayaran'])->name('pembayaran.update');

    Route::get('/pengaturan', function () {
        return view('pengaturan');
    })->name('pengaturan');

    Route::get('/pengaduan', [PengaduanController::class, 'showPengaduan'])->name('pengaduan.index');

    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');

    Route::put('/pengaduan/{id}/balasan', [PengaduanController::class, 'updateBalasan'])->name('pengaduan.updateBalasan');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.export');

    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
