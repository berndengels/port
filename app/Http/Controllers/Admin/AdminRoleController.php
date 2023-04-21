<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Requests\RoleRequest;

class AdminRoleController extends AdminController
{
    /**
     * @var Collection
     */
    protected $permissions;
    protected $guards;

    public function __construct()
    {
        $this->guards = collect(config('auth.guards'))->map(fn($v,$k) => $k)->toArray();
        $this->permissions = Permission::orderBy('guard_name')
            ->orderBy('name')
            ->get()
            ->keyBy('id')
            ->map(
                function ($item) {
                    return "$item->guard_name $item->name";
                }
            );
    }

    public function index()
    {
        $data = Role::paginate($this->paginatorLimit);
        return view('admin.roles.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.roles.create', [
            'permissions' => $this->permissions,
            'guards' => $this->guards,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $permissions = isset($request->validated()['permissions']) ? $request->validated()['permissions'] : null;
            $role = Role::create(collect($request->validated())->except(['permissions'])->toArray());
            if($permissions) {
                $role->syncPermissions($permissions);
            }
            return redirect()->route('admin.roles.index')->with('success', 'Rolle erfolgreich angelegt!');
        } catch(Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $guards = $this->guards;
        $permissions = $this->permissions;
        return view('admin.roles.edit', compact('role', 'permissions','guards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest $request
     * @param  Role        $role
     * @return Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        try {
            $permissions = isset($request->validated()['permissions']) ? $request->validated()['permissions'] : null;
            $role->syncPermissions($permissions)->update($request->validated());
            return redirect()->route('admin.roles.index')->with('success', 'Rolle erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return Response
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return back()->with('success', 'Rolle erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
