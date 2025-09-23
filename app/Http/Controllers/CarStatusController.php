<?php

namespace App\Http\Controllers;

use App\Models\CarStatuses;
use Illuminate\Http\Request;

class CarStatusController extends Controller
{
    public function index()
    {
        $carStatuses = CarStatuses::get();
        return view('admin.car-statuses.index', compact('carStatuses'));
    }

    public function create()
    {
        return view('admin.car-statuses.create');
    }

    // Method to return a partial view for modal form
    public function createModal()
    {
        return view('admin.car-statuses.create_modal');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Название_статуса' => 'required|string|max:50|unique:Статусы_автомобилей,Название_статуса',
        ]);

        $carStatus = CarStatuses::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Статус автомобиля успешно добавлен.',
                'new_id' => $carStatus->id_статуса,
                'new_text' => $carStatus->Название_статуса,
                'select_id' => 'id_статуса' // This tells the JS which select to update
            ]);
        }

        return redirect()->route('admin.car-statuses.index')->with('success', 'Статус автомобиля успешно добавлен.');
    }

    public function show(CarStatuses $carStatus)
    {
        return view('admin.car-statuses.show', compact('carStatus'));
    }

    public function edit($id)
    {
        $carStatus = CarStatuses::findOrFail($id);
        return view('admin.car-statuses.edit', compact('carStatus'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Название_статуса' => 'required|string|max:50|unique:Статусы_автомобилей,Название_статуса,' . $id . ',id_статуса',
        ]);

        $carStatus = CarStatuses::findOrFail($id);
        $carStatus->update($validated);

        return redirect()->route('admin.car-statuses.index')->with('success', 'Статус автомобиля успешно обновлен.');
    }

    public function destroy($id)
    {
        $carStatus = CarStatuses::findOrFail($id);
        // Add check for related records if necessary
        $carStatus->delete();

        return redirect()->route('admin.car-statuses.index')->with('success', 'Статус автомобиля успешно удален.');
    }

    public function getAll()
    {
        $carStatuses = CarStatuses::all();
        return response()->json($carStatuses);
    }
} 