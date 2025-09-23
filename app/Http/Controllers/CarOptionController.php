<?php

namespace App\Http\Controllers;

use App\Models\CarOption;
use Illuminate\Http\Request;

class CarOptionController extends Controller
{
    public function index()
    {
        $carOptions = CarOption::get();
        return view('admin.car-options.index', compact('carOptions'));
    }

    public function create()
    {
        return view('car-options.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Название_опции' => 'required|string|max:255|unique:Опции_автомобилей,Название_опции',
            'Описание_опции' => 'nullable|string',
            'Стоимость_опции' => 'nullable|numeric|min:0',
        ]);

        CarOption::create($validated);

        return redirect()->route('admin.car-options.index')->with('success', 'Опция автомобиля успешно добавлена.');
    }

    public function show(CarOption $carOption)
    {
        return view('car-options.show', compact('carOption'));
    }

    public function edit($id)
    {
        $carOption = CarOption::findOrFail($id);
        return view('car-options.edit', compact('carOption'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
             'Название_опции' => 'required|string|max:255|unique:Опции_автомобилей,Название_опции,' . $id . ',ID_опции',
            'Описание_опции' => 'nullable|string',
            'Стоимость_опции' => 'nullable|numeric|min:0',
        ]);

        $carOption = CarOption::findOrFail($id);
        $carOption->update($validated);

        return redirect()->route('admin.car-options.index')->with('success', 'Опция автомобиля успешно обновлена.');
    }

    public function destroy($id)
    {
        $carOption = CarOption::findOrFail($id);
        // Add check for related records if necessary
        $carOption->delete();

        return redirect()->route('admin.car-options.index')->with('success', 'Опция автомобиля успешно удалена.');
    }
} 