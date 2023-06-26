<?php
namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Boat;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminUploadController extends AdminController
{
    public function imageUpload( ImageRequest $request, Boat $boat )
    {
        try {
			$boat
				->addMediaFromRequest('image')
				->toMediaCollection('boat', 'images')
			;
            $response = [
                'success'   => true,
                'error'     => null,
                'link'      => $boat->getMedia('boat')->first()->getUrl('large'),
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
