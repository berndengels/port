<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccessLog;
use Jenssegers\Agent\Agent;

class AdminAccessLogController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AccessLog::orderByDesc('created_at')->paginate($this->paginatorLimit);
        return view('admin.access_logs.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccessLog  $accessLog
     * @return \Illuminate\Http\Response
     */
    public function show(AccessLog $accessLog)
    {
        return view('admin.access_logs.show', compact('accessLog'));
    }
}
