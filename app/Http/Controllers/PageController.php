<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Page $page
     * @return Response
     */
    public function show($slug)
    {
        $data = Page::whereSlug($slug)->first();
        return view('public.pages.show', compact('data'));
    }
}
