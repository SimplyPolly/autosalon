<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarProductType;

class CarProductTypeController extends Controller
{
    // Вывод списка типов товаров
    public function index()
    {
        $carProductTypes = CarProductType::get();
        $employee = auth('employee')->user();
        return view('car-product-types.index', compact('carProductTypes', 'employee'));
    }

    // Показывает конкретный тип товара
    public function show(CarProductType $car_product_type)
    {
        return view('car-product-types.show', compact('car_product_type'));
    }

    public function create()
    {
        return view('car-product-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_product_types,name',
            'description' => 'nullable|string'
        ]);

        CarProductType::create($validated);

        return redirect()->route('admin.car-product-types.index')
            ->with('success', 'Product type successfully added');
    }

    public function edit(CarProductType $car_product_type)
    {
        return view('car-product-types.edit', compact('car_product_type'));
    }

    public function update(Request $request, CarProductType $car_product_type)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_product_types,name,' . $car_product_type->id,
            'description' => 'nullable|string'
        ]);

        $car_product_type->update($validated);

        return redirect()->route('admin.car-product-types.index')
            ->with('success', 'Product type successfully updated');
    }

    public function destroy(CarProductType $car_product_type)
    {
        if ($car_product_type->products()->count() > 0) {
            return redirect()->route('admin.car-product-types.index')
                ->with('error', 'Cannot delete product type while there are associated products');
        }

        $car_product_type->delete();

        return redirect()->route('admin.car-product-types.index')
            ->with('success', 'Product type successfully deleted');
    }
}