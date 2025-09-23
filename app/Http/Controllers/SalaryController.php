<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = \App\Models\Salary::with('employee')->get();
        $employee = auth('employee')->user();
        return view('admin.salaries.index', compact('salaries', 'employee'));
    }

    public function create()
    {
        $employees = Employee::with('jobTitle')->get();
        return view('admin.salaries.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_сотрудника' => 'required|exists:Сотрудники,id_сотрудника',
            'Сумма' => 'required|numeric|min:0',
            'Дата_выплаты' => 'required|date',
            'Тип_выплаты' => 'required|in:Оклад,Премия,Штраф',
            'Комментарий' => 'nullable|string|max:255'
        ]);

        Salary::create($validated);

        return redirect()->route('admin.salaries.index')
            ->with('success', 'Зарплата успешно добавлена');
    }

    public function show(Salary $salary)
    {
        $salary->load(['employee.jobTitle']);
        return view('admin.salaries.show', compact('salary'));
    }

    public function edit(Salary $salary)
    {
        $employees = Employee::with('jobTitle')->get();
        return view('admin.salaries.edit', compact('salary', 'employees'));
    }

    public function update(Request $request, Salary $salary)
    {
        $validated = $request->validate([
            'id_сотрудника' => 'required|exists:Сотрудники,id_сотрудника',
            'Сумма' => 'required|numeric|min:0',
            'Дата_выплаты' => 'required|date',
            'Тип_выплаты' => 'required|in:Оклад,Премия,Штраф',
            'Комментарий' => 'nullable|string|max:255'
        ]);

        $salary->update($validated);

        return redirect()->route('admin.salaries.index')
            ->with('success', 'Зарплата успешно обновлена');
    }

    public function destroy(Salary $salary)
    {
        $salary->delete();

        return redirect()->route('admin.salaries.index')
            ->with('success', 'Зарплата успешно удалена');
    }
}
