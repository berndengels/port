<?php

namespace App\Http\Controllers\Api;

use App\Models\Media;
use App\Http\Controllers\Controller;

class ApiMediaController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $file)
    {
//        return response()->json(['media' => $file]);
        $result = [
            'success' => false,
            'error'	=> null,
        ];
        try {
            $result = [
                'success' => true,
                'file'    => $file->first()
            ];
            $file->delete();
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return response()->json($result);
    }
}
