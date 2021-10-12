<?php
namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'fon' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'postcode' => ['required', 'string', 'max:50'],
            'street' => ['required', 'string', 'max:50'],
        ]);
    }

    /**
     * Create a new customer instance after a valid registration.
     *
     * @param  array  $data
     * @return Customer
     */
    protected function create(array $data)
    {
        $customer = Customer::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'fon'       => $data['fon'],
            'city'      => $data['city'],
            'postcode'  => $data['postcode'],
            'street'    => $data['street'],
        ]);

        event(new Registered($customer));

        return $customer;
    }
}
