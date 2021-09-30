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

    public function __construct()
    {
        $this->permissions = Permission::orderBy('name')
            ->get()
            ->keyBy('id')
            ->map
            ->name;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Role::paginate(config('port.default.pagination.limit'));
        return view('admin.roles.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
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
        return view('admin.roles.create', ['permissions' => $this->permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        try {
            Role::create($request->validated())->syncPermissions($request->validated()['permissions']);
            return redirect()->route('admin.roles.index')->with('success', 'Rolle erfogreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $permissions = $this->permissions;
        return view('admin.roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        try {
            $role->syncPermissions($request->validated()['permissions'])->update($request->validated());
            return redirect()->route('admin.roles.index')->with('success', 'Rolle erfogreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return back()->with('success', 'Rolle erfogreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
