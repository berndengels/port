<?php

namespace App\Http\Controllers\Admin;

use App\Models\Widget;
use Illuminate\Http\Response;
use App\Http\Requests\WidgetRequest;


class AdminWidgetController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $data = Widget::orderBy('position')->paginate(config('port.main.default.pagination.limit'));
        return view('admin.widgets.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Widget $widget
     * @return Response
     */
    public function show(Widget $widget)
    {
        return view('admin.widgets.show', compact('widget'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.widgets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WidgetRequest $request
     * @return Response
     */
    public function store(WidgetRequest $request)
    {
        try {
            Widget::create($request->validated());
            return redirect()->route('admin.widgets.index')->with('success', 'Widget erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Widget $widget
     * @return Response
     */
    public function edit(Widget $widget)
    {
        return view('admin.widgets.edit', compact('widget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WidgetRequest $request
     * @param  Widget        $widget
     * @return Response
     */
    public function update(WidgetRequest $request, Widget $widget)
    {
        try {
            $widget->update($request->validated());
            return redirect()->route('admin.widgets.index')->with('success', 'Widget erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Widget $widget
     * @return Response
     */
    public function destroy(Widget $widget)
    {
        try {
            $widget->delete();
            return back()->with('success', 'Widget erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
