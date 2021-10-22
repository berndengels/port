<?php
namespace App\Http\Controllers\Admin;

use App\Models\Customer;
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
//        $this->middleware(['auth:admin','auth:customer']);
        $this->customerTypeOptions = config('port.main.customer.typeOptions');
        $this->customerTypes = collect($this->customerTypeOptions)->map(function ($v, $k) {
            return $k;
        });
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
     * @param Customer $customer
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
        return view('admin.customers.create', ['customerTypes' => $this->customerTypeOptions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @return Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            Customer::create($validated);
            return redirect()->route('admin.customers.index')->with('success', 'Kunde erfogreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Response
     */
    public function edit(Customer $customer)
    {
        $customerTypes = $this->customerTypeOptions;
        $customer->password = null;
        $customer->password_repeat = null;
        return view('admin.customers.edit', compact('customer','customerTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $validated = $request->validated();
            if($validated['password']) {
                $validated['password'] = Hash::make($validated['password']);
            }
            $customer->update($validated);
            return redirect()->route('admin.customers.index')->with('success', 'Kunde erfogreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return back()->with('success', 'Kunde erfogreich gelöscht!');
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
