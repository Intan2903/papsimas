<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function show($filename)
    {
        $path = base_path('public/qrcodes/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'QRCode tidak ditemukan');
        }

        return response()->file($path);
    }
}
