<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PengaduanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'loginMobile']);

Route::get('pengumuman/m', [PengumumanController::class, 'fetchPengumuman']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/qr/{qrcode}', [TagihanController::class, 'getTagihanByQrCode']);
    
    Route::post('pengumuman/m', [PengumumanController::class, 'buatPengumuman']);

    
    Route::get('/pengaduan', [PengaduanController::class, 'index']);
    Route::post('/pengaduan', [PengaduanController::class, 'store']);
    Route::put('/pengaduan/{id}/balasan/m', [PengaduanController::class, 'updateBalasanMobile']);
    
    Route::post('tagihan/{id}/konfirmasi-cash', [TagihanController::class, 'confirmCashPayment']);
    Route::get('/tagihan/user', [TagihanController::class, 'getUserPendingBills']);
    Route::get('/tagihan/search', [TagihanController::class, 'searchTagihan']);
    Route::post('/tagihan/bayar/{id}', [TagihanController::class, 'bayarTagihan']);
    Route::put('/tagihan/{tagihanId}/konfirmasi-pembayaran', [TagihanController::class, 'konfirmasiPembayaran']);
    
    Route::get('/riwayat-tagihan', [TagihanController::class, 'getRiwayatTagihan'])->name('riwayat-tagihan');
    Route::get('/riwayat/user', [TagihanController::class, 'getUserPaidBills']);

});