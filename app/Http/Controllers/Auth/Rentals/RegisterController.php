<?php
namespace App\Http\Controllers\Auth\Rentals;

use Exception;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Support\Facades\Event;
use App\Http\Requests\StoreRegistrationRequest;

/**
 *
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, HasEvents;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:customer');
    }

    /**
     * @return Guard|StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * @return Application|Factory|View
     */
    public function showRegistrationForm()
    {
        return view('public.auth.register', [
            'customerTypes' => config('port.main.customer.types'),
        ]);
    }

    /**
     * @param StoreRegistrationRequest $request
     * @return Application|JsonResponse|RedirectResponse|Redirector|mixed
     */
    public function register(StoreRegistrationRequest $request)
    {
        try {
            if(app()->environment(['testing'])) {
                Customer::flushEventListeners();
            }
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);

            /**
             * @var Customer $customer
             */
            $customer = Customer::create($validated);
            $customer->boats()->create($validated);

            Event::dispatch(new Registered($customer));

            $this->guard()->login($customer);

            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect()
                    ->route('public.dashboard')
                    ->with('success',"Kunde '$customer->name' erfolgreich angelegt")
                ;
        } catch(Exception $e) {
            if(app()->environment(['testing','local'])) {
                throw $e;
            }
            return redirect()
                ->back()
                ->withInput($request->validated())
                ->with('error', 'Bei der Registrierung ist leider ein Fehler aufgetreten!')
                ;
        }
    }
}
