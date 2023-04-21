<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Response;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends GuardedController
{
    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'customer';

    protected function index() {
        $profile = auth('customer')->user();
        return $this->show($profile);
    }
    /**
     * Display the specified resource.
     *
     * @param  Customer $profile
     * @return Response
     */
    public function show(Customer $profile)
    {
        return view('customer.profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer $profile
     * @return Response
     */
    public function edit(Customer $profile)
    {
        $profile->password = null;
        $profile->password_repeat = null;
        return view('customer.profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProfileRequest $request
     * @param  Customer       $profile
     * @return Response
     */
    public function update(ProfileRequest $request, Customer $profile)
    {
        try {
            $validated = $request->validated();

            if(!$request->password) {
                $validated = collect($validated)->except(['password','password_repeat'])->toArray();
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $profile->update($validated);

            return redirect()
                ->route('customer.profile.show', compact('profile'))
                ->with('success', 'Kunde erfolgreich bearbeitet!')
                ;
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
            auth('customer')->logout();
            return redirect()->route('public.dashboard')->with('success', 'Kunde erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create() {}
    public function store() {}
}
