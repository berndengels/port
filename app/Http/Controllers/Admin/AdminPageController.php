<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Response;
use App\Http\Requests\PageRequest;

class AdminPageController extends AdminController
{
    public function index()
    {
        $data = Page::paginate($this->paginatorLimit);
        return view('admin.pages.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Page $page
     * @return Response
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest $request
     * @return Response
     */
    public function store(PageRequest $request)
    {
        try {
            Page::create($request->validated());
            return redirect()->route('admin.pages.index')->with('success', 'Page erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Page $page
     * @return Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Page    $page
     * @return Response
     */
    public function update(PageRequest $request, Page $page)
    {
        try {
            $page->update($request->validated());
            return redirect()->route('admin.pages.index')->with('success', 'Page erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Page $page
     * @return Response
     */
    public function destroy(Page $page)
    {
        try {
            $page->delete();
            return back()->with('success', 'Page erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
