<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'employees_count' => DB::table('employees')->count(),
            'cars_count' => DB::table('cars')->count(),
            'deals_count' => DB::table('deals')->count(),
            'total_salary' => DB::table('salaries')->sum('amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
} 