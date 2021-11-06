<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminUploadController extends AdminController
{
    public function imageUpload( Request $request, string $paramName)
    {
        try {
            /**
             * @var $file UploadedFile
             */
            $file = $request->$paramName;
            $disk = Storage::disk('images');
            $path = str_replace(config('app.url'), '', $disk->url(''));
            $fileName = $disk->putFileAs('', $file, $file->hashName());
            $response = [
                'success'   => true,
                'error'     => null,
                'link'      => $path.$fileName,
            ];
        } catch (Exception $e) {
            $response = [
                'success'   => false,
                'error'     => $e->getMessage(),
                'link'      => null,
            ];
        }
        return response()->json($response);
    }
}
