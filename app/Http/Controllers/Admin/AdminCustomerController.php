<?php
namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Notifications\RegistrationConfirmed;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController as DefaultLoginController;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends AdminController
{
    //    use AuthenticatesUsers;

    protected $customerTypes;
    protected $customerTypeOptions;
    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'customer';

    public function __construct()
    {
        parent::__construct();
        //        $this->middleware(['auth:admin','auth:customer']);
        $this->customerTypeOptions = config('port.main.customer.typeOptions');
        $this->customerTypes = collect($this->customerTypeOptions)->map(fn ($v, $k) => $k);
    }

    public function index()
    {
        $data = Customer::whereCustomerType($this->customerTypes['permanent'])->paginate($this->paginatorLimit);
        return view('admin.customers.index', compact('data'));
    }

    public function guests()
    {
        $data = Customer::whereCustomerType($this->customerTypes['guest'])->paginate($this->paginatorLimit);
        return view('admin.customers.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Customer $customer
     * @return Response
     */
    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.customers.create', [
            'roles' => $this->roleRepository->setGuardName('customer')->options()->getSelectOptions(),
            'customerTypes' => $this->customerTypeOptions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerRequest $request
     * @return Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            Customer::create($validated)->roles()->sync($validated['roles']);
            return redirect()->route('admin.customers.index')->with('success', 'Kunde erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer $customer
     * @return Response
     */
    public function edit(Customer $customer)
    {
        $customer->load('roles');
        $roles = $this->roleRepository->setGuardName('customer')->options()->getSelectOptions();
        $customerTypes = $this->customerTypeOptions;
        $customer->password = null;
//        $customer->password_repeat = null;
        $confirmed = $customer->confirmed;
        return view('admin.customers.edit', compact('customer', 'confirmed','customerTypes', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerRequest $request
     * @param  Customer        $customer
     * @return Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $validated = $request->validated();

            if(!$request->password) {
                $validated = collect($validated)->except(['password','password_repeat'])->toArray();
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $customer->syncRoles($validated['roles'] ?? [])->update($validated);

            if($customer->confirmed && !$validated['confirmed_old']) {
                $customer->notify(new RegistrationConfirmed($customer));
            }

            return redirect()->route('admin.customers.index')->with('success', 'Kunde erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('admin.customers.index')->with('success', 'Kunde erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirm(Customer $customer)
    {
        $customer->confirmed = true;
        $customer->save();
        return $this->show($customer);
    }
}
