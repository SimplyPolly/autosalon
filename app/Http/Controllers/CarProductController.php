<?php

namespace App\Http\Controllers;

use App\Models\CarProduct;
use Illuminate\Http\Request;

class CarProductController extends Controller
{
    public function index()
    {
        $carProducts = CarProduct::with('type')->get();
        $employee = auth('employee')->user();
        return view('admin.car-products.index', compact('carProducts', 'employee'));
    }
} 