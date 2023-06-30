<?php
namespace App\Http\Controllers\Admin;

class AdminDashboardController extends AdminController
{
    public function show()
    {
	    return view('admin.vue-dashboard');
    }
}
