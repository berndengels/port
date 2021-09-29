<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;

class AdminUserController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = User::with('roles')->paginate(config('port.default.pagination.limit'));
        return view('admin.users.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.users.create', ['roles' => $this->rolesOptions ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        try {
            User::create($request->validated())->syncRoles($request->validated()['roles']);
            return redirect()->route('admin.users.index')->with('success', 'User erfogreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $user->password = null;
        return view('admin.users.edit', [
            'user'  => $user,
            'roles' => $this->rolesOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();
            if(!$request->password) {
                $validated = collect($validated)->except(['password','password_repeat'])->toArray();
            }
            $user
                ->syncRoles($validated['roles'])
                ->update($validated)
            ;
            return redirect()->route('admin.users.index')->with('success', 'User erfogreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return back()->with('success', 'User erfogreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
