<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminQrCodeController extends Controller
{
    public function index()
    {
        $url    = 'https://kiez.goldenacker.de/';
        $file   = storage_path('app/public/qrcodes/') . 'kiez-qrc.png';
        $imgUrl = '/storage/qrcodes/kiez-qrc.png';
        $data   = QrCode::format('png')->size(300)->generate($url);
        file_put_contents($file, $data);
        return view('admin.qrcode', compact('imgUrl'));
    }
}
