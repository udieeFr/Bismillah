<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class studentDashboard extends BaseController
{
    public function index()
    {
        return view('v_stDashboard'); // You'll need to create this view
    }
}