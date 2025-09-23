<?php

namespace App\Http\Controllers;

use App\Models\CarModels;
use App\Models\CarBrands;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function index()
    {
        $models = CarModels::with('brand')->get();
        $carBrands = CarBrands::all();
        $employee = auth('employee')->user();
        return view('admin.car-models.index', compact('models', 'carBrands', 'employee'));
    }

    public function create()
    {
        $brands = CarBrands::all();
        return view('admin.car-models.create', compact('carBrands'));
    }

    // Method to return a partial view for modal form
    public function createModal()
    {
        $brands = CarBrands::all();
        return view('admin.car-models.create_modal', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_brand_id' => 'required|exists:car_brands,id',
            'name' => 'required|string|max:100|unique:car_models,name',
            'color' => 'nullable|string|max:50',
            'seats' => 'nullable|integer|min:1',
            'trunk_volume' => 'nullable|integer|min:0',
            'horsepower' => 'nullable|integer|min:0',
            'engine_volume' => 'nullable|numeric|min:0',
            'fuel_type' => 'nullable|string|max:50',
        ]);

        $carModel = CarModels::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Model successfully added.',
                'new_id' => $carModel->id,
                'new_text' => $carModel->name,
                'select_id' => 'model_id'
            ]);
        }

        return redirect()->route('admin.car-models.index')->with('success', 'Model successfully added');
    }

    public function show($id)
    {
        $model = CarModels::with('brand')->findOrFail($id);
        $employee = auth('employee')->user();
        return view('admin.car-models.show', compact('model', 'employee'));
    }

    public function edit($id)
    {
        $carModel = CarModels::findOrFail($id);
        $brands = CarBrands::all();
        return view('admin.car-models.edit', compact('carModel', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'car_brand_id' => 'required|exists:car_brands,id',
            'name' => 'required|string|max:100|unique:car_models,name,' . $id . ',id',
            'color' => 'nullable|string|max:50',
            'seats' => 'nullable|integer|min:1',
            'trunk_volume' => 'nullable|integer|min:0',
            'horsepower' => 'nullable|integer|min:0',
            'engine_volume' => 'nullable|numeric|min:0',
            'fuel_type' => 'nullable|string|max:50',
        ]);
        $carModel = CarModels::findOrFail($id);
        $carModel->update($validated);
        return redirect()->route('admin.car-models.index')->with('success', 'Model successfully updated');
    }

    public function destroy($id)
    {
        $carModel = CarModels::findOrFail($id);
        // Проверка на связанные записи (автомобили), прежде чем удалить
        if ($carModel->cars()->count() > 0) {
            return redirect()->route('admin.car-models.index')->with('error', 'Cannot delete model while there are associated cars.');
        }
        $carModel->delete();
        return redirect()->route('admin.car-models.index')->with('success', 'Model successfully deleted');
    }

    public function getByBrand($brandId)
    {
        $models = CarModels::where('car_brand_id', $brandId)->get();
        return response()->json($models);
    }
} 