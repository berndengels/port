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
    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'customer';

    public function __construct()
    {
//        $this->middleware(['auth:admin','auth:customer']);
        $this->customerTypes = json_decode(config('port.main.customer.types'), true);
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.customers.create', ['customerTypes' => $this->customerTypes]);
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
        $customerTypes = $this->customerTypes;
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


}
