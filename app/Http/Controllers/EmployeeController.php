<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['jobTitle', 'salon'])->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $jobTitles = JobTitle::all();
        $salons = Salon::all();
        return view('admin.employees.create', compact('jobTitles', 'salons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Фамилия' => 'required|string|max:100',
            'Имя' => 'required|string|max:100',
            'Отчество' => 'nullable|string|max:100',
            'Телефон' => 'nullable|string|max:15',
            'email' => 'required|email|unique:Сотрудники,email',
            'Пароль' => 'required|string|min:8',
            'title' => 'required|string|max:255',
            'job_title_id' => 'required|exists:job_titles,id',
            'salon_id' => 'required|exists:salons,id',
        ]);

        $validated['Пароль'] = Hash::make($validated['Пароль']);

        Employee::create($validated);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник успешно добавлен');
    }

    public function edit(Employee $employee)
    {
        $jobTitles = JobTitle::all();
        $salons = Salon::all();
        return view('admin.employees.edit', compact('employee', 'jobTitles', 'salons'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'Фамилия' => 'required|string|max:100',
            'Имя' => 'required|string|max:100',
            'Отчество' => 'nullable|string|max:100',
            'Телефон' => 'nullable|string|max:15',
            'email' => 'required|email|unique:Сотрудники,email,' . $employee->id_сотрудника . ',id_сотрудника',
            'title' => 'required|string|max:255',
            'job_title_id' => 'required|exists:job_titles,id',
            'salon_id' => 'required|exists:salons,id',
        ]);

        if ($request->filled('Пароль')) {
            $validated['Пароль'] = Hash::make($request->Пароль);
        }

        $employee->update($validated);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник успешно обновлен');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник успешно удален');
    }
} 