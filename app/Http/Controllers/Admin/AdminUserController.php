<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\AdminUser;
use Illuminate\Http\Response;
use App\Http\Requests\AdminUserRequest;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends AdminController
{

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /**
         * @var $user AdminUser
         */
        $user = auth('admin')->user();
        $query = AdminUser::with('roles');

        if($user && !$user->hasRole('admin')) {
            $query->whereId($user->id);
        }

        $data = $query->paginate(config('port.main.default.pagination.limit'));
        return view('admin.users.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param AdminUser $user
     * @return Response
     */
    public function show(AdminUser $user)
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
     * @param AdminUserRequest $request
     * @return Response
     */
    public function store(AdminUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            AdminUser::create($validated)->syncRoles($validated['roles']);
            return redirect()->route('admin.users.index')->with('success', 'User erfogreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AdminUser $user
     * @return Response
     */
    public function edit(AdminUser $user)
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
     * @param AdminUserRequest $request
     * @param AdminUser $user
     * @return Response
     */
    public function update(AdminUserRequest $request, AdminUser $user)
    {
        try {
            $validated = $request->validated();
            if(!$request->password) {
                $validated = collect($validated)->except(['password','password_repeat'])->toArray();
            } else {
                $validated['password'] = Hash::make($validated['password']);
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
     * @param AdminUser $user
     * @return Response
     */
    public function destroy(AdminUser $user)
    {
        try {
            $user->delete();
            return back()->with('success', 'User erfogreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
