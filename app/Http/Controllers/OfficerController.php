<?php

namespace App\Http\Controllers;

use App\Models\ReportedRoad;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function officerDashboard()
    {
        $reports = ReportedRoad::all();
        
        return view('officer.officer-dashboard',compact('reports'));
    }
    
}
