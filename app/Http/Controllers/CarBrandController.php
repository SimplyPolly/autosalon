<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarBrands;
use App\Http\Controllers\Controller;

class CarBrandController extends Controller
{
    public function index()
    {
        $brands = CarBrands::get();
        $employee = auth('employee')->user();
        return view('admin.car-brands.index', compact('brands', 'employee'));
    }

    public function create()
    {
        return view('admin.car-brands.create');
    }

    public function createModal()
    {
        return view('admin.car-brands.create_modal');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:car_brands,name',
            'country' => 'required|string|max:255'
        ]);

        $brand = CarBrands::create($validatedData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Brand successfully added.',
                'new_id' => $brand->id,
                'new_text' => $brand->name,
                'select_id' => 'brand_id'
            ]);
        }

        return redirect()->route('admin.car-brands.index')->with('success', 'Brand successfully added.');
    }

    public function edit($id)
    {
        $brand = CarBrands::findOrFail($id);
        return view('admin.car-brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:car_brands,name,' . $id . ',id',
            'country' => 'required|string|max:255'
        ]);

        $brand = CarBrands::findOrFail($id);
        $brand->update($validatedData);
        return redirect()->route('admin.car-brands.index')->with('success', 'Brand successfully updated.');
    }

    public function destroy($id)
    {
        $brand = CarBrands::findOrFail($id);
        $brand->delete();
        return redirect()->route('admin.car-brands.index')->with('success', 'Brand successfully deleted.');
    }

    public function getAll()
    {
        $brands = CarBrands::all();
        return response()->json($brands);
    }
}