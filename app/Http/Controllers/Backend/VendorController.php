<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function dashboard(): View
    {
        return view('vendor.dashboard');
    }
}
