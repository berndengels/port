<?php
namespace App\Http\Controllers\Admin;

use App\Models\Media;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminUploadController extends AdminController
{
    public function imageUpload(Request $request)
    {
        $model = $request->post('model_type');
        $id = $request->post('model_id');
        $mediaName = lcfirst(class_basename($model));

        $response = [
            'success'   => false,
            'error'     => 'error: wrong model or id!',
        ];

        if(!$model || !$id) {
            return response()->json($response);
        }

        try {
            $model = app($model)->find($id);
            $model
				->addMediaFromRequest('image')
				->toMediaCollection($mediaName, 'images')
			;
            $response = [
                'success'   => true,
                'error'     => null,
            ];
        } catch (Exception $e) {
            $response = [
                'success'   => false,
                'error'     => $e->getMessage(),
            ];
        }
        return response()->json($response);
    }
}
