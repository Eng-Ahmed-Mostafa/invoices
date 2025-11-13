<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashborad extends Controller
{
    /**
     * Display a listing of the dashboard.
     */
    public function index()
    {
        return view('dashboard.dashboard');
    }
}
