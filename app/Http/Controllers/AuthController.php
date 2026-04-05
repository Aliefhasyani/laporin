<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function officerDashboard()
    {
        return view('officer.officer-dashboard');
    }
}
