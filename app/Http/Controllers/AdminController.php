<?php

namespace App\Http\Controllers;

use App\Models\ChargePoint;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $charge_points = ChargePoint::all();
        $customers = User::all();
        return view('admin.dashboard', compact('charge_points', 'customers'));
    }
}
