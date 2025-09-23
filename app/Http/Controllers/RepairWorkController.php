<?php

namespace App\Http\Controllers;

use App\Models\RepairWork;
use App\Models\Car;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\RepairWorksExport;
use Maatwebsite\Excel\Facades\Excel;

class RepairWorkController extends Controller
{
    public function index()
    {
        $repairWorks = RepairWork::with(['car', 'employee'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.repair-works.index', compact('repairWorks'));
    }

    public function create()
    {
        $cars = Car::with('brand', 'model')->get();
        $mechanics = Employee::whereHas('jobTitle', function($query) {
            $query->where('title', 'Механик');
        })->get();
        
        return view('admin.repair-works.create', compact('cars', 'mechanics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'mechanic_id' => 'required|exists:employees,id',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'cost' => 'required|numeric|min:0'
        ]);

        RepairWork::create($validated);

        return redirect()->route('repair-works.index')
            ->with('success', 'Ремонтная работа успешно создана');
    }

    public function edit(RepairWork $repairWork)
    {
        $cars = Car::with('brand', 'model')->get();
        $mechanics = Employee::whereHas('jobTitle', function($query) {
            $query->where('title', 'Механик');
        })->get();
        
        return view('admin.repair-works.edit', compact('repairWork', 'cars', 'mechanics'));
    }

    public function update(Request $request, RepairWork $repairWork)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'mechanic_id' => 'required|exists:employees,id',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'cost' => 'required|numeric|min:0'
        ]);

        $repairWork->update($validated);

        return redirect()->route('repair-works.index')
            ->with('success', 'Ремонтная работа успешно обновлена');
    }

    public function destroy(RepairWork $repairWork)
    {
        $repairWork->delete();

        return redirect()->route('repair-works.index')
            ->with('success', 'Ремонтная работа успешно удалена');
    }

    public function export()
    {
        return Excel::download(new RepairWorksExport, 'repair-works.xlsx');
    }
} 