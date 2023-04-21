<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ModelHelper;
use App\Models\Permission;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Requests\PermissionRequest;

class AdminPermissionController extends AdminController
{
    /**
     * @var Collection
     */
    protected $models;
    protected $actions;
    protected $guards;

    public function __construct()
    {
        $this->actions = Permission::actions();
        $this->models = ModelHelper::allModels()->keys()->keyBy(fn ($v) => $v);
        $this->guards = [
            ''      => 'Bitte wählen',
            'admin' => 'Admin',
            'customer'  => 'Customer',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Permission::filter('name')->paginate($this->paginatorLimit);
        return view('admin.permissions.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Permission $permission
     * @return Response
     */
    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.permissions.create', [
            'guards'    => $this->guards,
            'models'    => $this->models,
            'actions'   => $this->actions,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PermissionRequest $request
     * @return Response
     */
    public function store(PermissionRequest $request)
    {
        try {
            Permission::create($request->validated());
            return redirect()->route('admin.permissions.index')->with('success', 'Permission erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission $permission
     * @return Response
     */
    public function edit(Permission $permission)
    {
        $guards = $this->guards;
        $models = $this->models;
        $actions = $this->actions;
        return view('admin.permissions.edit', compact('permission', 'models', 'actions', 'guards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PermissionRequest $request
     * @param  Permission        $permission
     * @return Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        try {
            $permission->update($request->validated());
            return redirect()->route('admin.permissions.index')->with('success', 'Permission erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission $permission
     * @return Response
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return back()->with('success', 'Permission erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
