<?php
namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Role;
use Illuminate\Http\Response;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RegistrationConfirmed;
use Illuminate\Support\Str;

class AdminCustomerController extends AdminController
{
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
        session()->remove('from');
        $type = 'permanent';
        $data = Customer::whereType($this->customerTypes[$type])->paginate($this->paginatorLimit);
        return view('admin.customers.index', compact('data','type'));
    }

    public function guest()
    {
        $type = 'guest';
        session()->put('from',$type);
        $data = Customer::whereType($this->customerTypes[$type])->paginate($this->paginatorLimit);
        return view('admin.customers.index', compact('data','type'));
    }

    public function renter()
    {
        $type = 'renter';
        session()->put('from',$type);
        $data = Customer::whereType($this->customerTypes[$type])->paginate($this->paginatorLimit);
        return view('admin.customers.index', compact('data','type'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Customer $customer
     * @return Response
     */
    public function show(Customer $customer)
    {
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        return view('admin.customers.show', compact('customer', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($type)
    {
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        switch ($type) {
            case 'permanent':
            case 'guest':
                $role = Role::whereName('boat')->first() ? Role::whereName('boat')->first()->id : null;
                break;
            case 'renter':
                $role = Role::whereName('renter')->first() ? Role::whereName('renter')->first()->id : null;
                break;
            default:
                break;
        }
        return view('admin.customers.create', [
            'roles' => $this->roleRepository->setGuardName('customer')->options()->getSelectOptions(),
            'type'  => $type,
            'route' => $route,
            'role'  => $role,
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
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        try {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $customer = Customer::create($validated);
            $customer->roles()->sync($validated['roles']);
//            $route = ('permanent' === $customer->type) ? 'index' : $customer->type;
            return redirect()->route('admin.customers.'.$route)->with('success', 'Kunde erfolgreich angelegt!');
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
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        $customer->load('roles');
        $roles = $this->roleRepository->setGuardName('customer')->options()->getSelectOptions();
        $customerTypes = $this->customerTypeOptions;
        $customer->password = null;
        $confirmed = $customer->confirmed;

        return view('admin.customers.edit', compact('customer', 'confirmed','customerTypes', 'roles', 'route'));
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
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
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

            return redirect()->route('admin.customers.'.$route)->with('success', 'Kunde erfolgreich bearbeitet!');
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
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        try {
            $customer->roles()->detach();
            $customer->delete();
            return redirect()->route('admin.customers.'.$route)->with('success', 'Kunde erfolgreich gelöscht!');
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
