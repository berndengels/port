<?php
namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use App\Http\Requests\RegistrationRequest;

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
        return view(
            'public.auth.register', [
            'boatTypes' => collect(config('port.main.boat.types'))->prepend('Bitte wählen', null),
            'customerTypes' => config('port.main.customer.types'),
            ]
        );
    }

    /**
     * @param RegistrationRequest $request
     * @return Application|JsonResponse|RedirectResponse|Redirector|mixed
     */
    public function register(RegistrationRequest $request)
    {
        try {
            $customer = Customer::create($request->validated());
            $customer->boats()->create($request->validated());

            event(new Registered($customer));
            $this->guard()->login($customer);

            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect()
                    ->route('public.dashboard')
                    ->with('success',"Kunde '$customer->name' erfolgreich angelegt")
                ;
        } catch(Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->validated())
                ->with('error', 'Bei der Registrierung ist leider ein Fehler aufgetreten!')
                ;
        }
    }
}
