<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

class DashboardController extends AdminController {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.dashboard');
    }

}
