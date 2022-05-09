<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController as DefaultLoginController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class CustomerLoginController extends DefaultLoginController
{
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('public.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Login the customer.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            //Fire the lockout event.
            $this->fireLockoutEvent($request);

            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }

        //attempt login
        if( $this->guard()->attempt(
                $request->only('email', 'password'),
                $request->filled('remember')
            ) && 1 == $this->guard()->user()->confirmed
        ) {
            //Authenticated
            return redirect()
                ->intended(route('public.dashboard'))
                ->with('status', 'You are Logged in as Customer!');
        } else {
            $this->guard()->logout();
            return redirect()
                ->back()
                ->with('error', 'Sorry, Ihre Kunden-Registrierung wurde noch nicht bestätigt !');
        }

        //keep track of login attempts from the user.
        $this->incrementLoginAttempts($request);

        //Authentication failed
        return $this->sendFailedLoginResponse($request);
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['confirmed' => true]);
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    public function signin(Request $request, $customerId) {
        $customer = Customer::find($customerId);
        if($request->hasValidSignature() && $customer) {
            $this->guard()->login($customer);
            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect()
                    ->route('public.dashboard')
                    ->with('success',"Kunde '$customer->name' erfolgreich angemeldet")
                ;
        }
        return redirect()->back()->with('error','Action not pertmitted!');
    }
}
