<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Notifications\AdminCraneDateRequest;
use Carbon\Carbon;
use App\Models\AdminUser;
use App\Models\CraneDate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCraneDateRequest;
use App\Http\Requests\UpdateCraneDateRequest;
use App\Http\Resources\CraneDatesResource;
use App\Notifications\CustomerCraneDateRequest;
use Illuminate\Http\Response;

class ApiCraneDateController extends Controller
{
	private $cranableTypes = [
		'guest'		=> 'App\\Models\\GuestBoat',
		'permanent'	=> 'App\\Models\\Boat',
	];

    private $cranableTypeOptions = [
        ['id' => null, 'name' => 'Art wählen'],
        ['id' => 'App\\Models\\GuestBoat', 'name' => 'Gastboot'],
        ['id' => 'App\\Models\\Boat', 'name' => 'Dauerlieger']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
		$admin		= $request->user('admin');
		$customer	= $request->user('customer');
		$response	= null;
		$query		= CraneDate::with(['cranable'])->orderBy('crane_date');

		if($admin) {
			$data = CraneDatesResource::collection($query->get());
			$response = [
				'dates' => $data,
				'customerDates' => null,
				'cranableType' => null,
				'cranableTypeOptions' => $this->cranableTypeOptions,
				'boats'	=> null,
			];
		}
		elseif($customer) {
			$type = $this->cranableTypes[$customer->type] ?? null;
			$data = CraneDatesResource::collection($query->get());

			$response = [
				'dates' => $data,
				'customerDates' => $customer->craneDates()->flatten()->map->id,
				'cranableType' => $type,
				'cranableTypeOptions' => null,
				'boats'	=> $customer->boats,
			];
		}

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function show(CraneDate $craneDate)
    {
        return response()->json($craneDate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCraneDateRequest  $request
     * @return Response
     */
    public function store(StoreCraneDateRequest $request)
    {
        try {
			$validated = $request->validated();
			$customer = $request->user('customer');
			$admin = $request->user('admin');
			$craneDate = CraneDate::create($validated);

			if($admin && $craneDate->customer && $validated['notify']) {
				$craneDate->customer->notify(new AdminCraneDateRequest($craneDate, __FUNCTION__));
			}

			if($customer) {
				$user = AdminUser::whereEmail(config('port.main.master.email'))->first();
				$user->notify(new CustomerCraneDateRequest($craneDate, __FUNCTION__));
			}

            return response()->json([
				'craneDate'  => new CraneDatesResource($craneDate),
                'success' => "Krantermin erfolgreich angelegt!"
            ]);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCraneDateRequest  $request
     * @param CraneDate $craneDate
     * @return Response
     */
    public function update(UpdateCraneDateRequest $request, CraneDate $craneDate)
    {
        try {
			$validated = $request->validated();
            $craneDate->update($validated);
			$craneDate = $craneDate->refresh();
			$customer = $request->user('customer');
			$admin = $request->user('admin');

			if($admin && $craneDate->customer && $validated['notify']) {
				$craneDate->customer->notify(new AdminCraneDateRequest($craneDate, __FUNCTION__));
			}

			if($customer) {
				$user = AdminUser::whereEmail(config('port.main.master.email'))->first();
				$user->notify(new CustomerCraneDateRequest($craneDate, __FUNCTION__));
			}

			return response()->json([
                'craneDate'  => new CraneDatesResource($craneDate),
                'success' => "Krantermin erfolgreich bearbeitet!"
            ]);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CraneDate $craneDate
     * @return Response
     */
    public function destroy(CraneDate $craneDate, Request $request)
    {
        try {
            $data = $craneDate;
			$customer = $request->user('customer');
			$admin = $request->user('admin');

			if($admin && $craneDate->customer) {
				$craneDate->customer->notify(new AdminCraneDateRequest($craneDate, __FUNCTION__));
			}

			if($customer) {
				$user = AdminUser::whereEmail(config('port.main.master.email'))->first();
				$user->notify(new CustomerCraneDateRequest($craneDate, __FUNCTION__));
			}

            $craneDate->delete();

            return response()->json([
				'craneDate'  => new CraneDatesResource($data),
                'success' => "Krantermin erfolgreich gelöscht!"
            ]);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function cranable(Request $request)
    {
        $cranableType = $request->post('cranable_type');

		if(auth('admin')->check()) {
			$data = $cranableType::orderBy('name')->get()->map(fn($k) => ['id' => $k->id, 'name' => $k->name]);
		} elseif (auth('customer')->check()) {
			$customer = auth('customer')->user();
			$data = $customer->boats->map(fn($k) => ['id' => $k->id, 'name' => $k->name]);
		}

        return response()->json($data);
    }
}
