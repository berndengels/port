<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WebhookResource;
use App\Models\EpWebhookCall;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiWebhookClientController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  Boat  $boat
     * @return Response
     */
    public function index(Request $request)
    {
		$name = $request->input('name');
		$action = $request->input('action');
		$query = EpWebhookCall::select();

		if($name) {
			$query->whereName($name);
		}

		if($action) {
			$query->whereAction($action);
		}

		$data = $query->get();
		$data = WebhookResource::collection($data);

        return response()->json($data);
    }

	public function show(EpWebhookCall $epWebhookCall) {
		$epWebhookCall = new WebhookResource($epWebhookCall);

		return response()->json($epWebhookCall);
	}
}
