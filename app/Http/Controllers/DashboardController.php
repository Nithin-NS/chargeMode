<?php

namespace App\Http\Controllers;

use App\Models\ChargePoint;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $chargepoints = ChargePoint::all();
        $customers = User::all();
        return view('pages.dashboard.index', compact('chargepoints', 'customers'));
    }
}
