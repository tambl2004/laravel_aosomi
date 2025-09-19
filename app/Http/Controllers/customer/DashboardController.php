<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard customer
     */
    public function index()
    {
        return view('customer.dashboard');
    }
}