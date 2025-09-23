<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarProduct;
use App\Models\CarProductType;
use Illuminate\Support\Facades\Auth;

class CarProductsController extends Controller
{
    public function index()
    {
        $carProducts = CarProduct::with('type')->get();
        $productTypes = CarProductType::all();
        $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;

        return view('car-products.index', compact('carProducts', 'productTypes', 'employee'));
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            abort(404);
        }

        $product = CarProduct::with('type')->findOrFail($id);
        $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;

        return view('car-products.show', compact('product', 'employee'));
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            abort(404);
        }

        $product = CarProduct::with('type')->findOrFail($id);
        $productTypes = CarProductType::all();
        $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;

        return view('car-products.edit', compact('product', 'productTypes', 'employee'));
    }

    public function search(Request $request)
    {
        $query = $request->get('search', '');

        $carProducts = CarProduct::with('type')
            ->where('name', 'ilike', "%{$query}%")
            ->orWhere('description', 'ilike', "%{$query}%")
            ->get();

        $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;

        return response()->json([
            'success' => true,
            'html' => view('car-products.table', compact('carProducts', 'employee'))->render(),
        ]);
    }

    public function sort(Request $request)
    {
        $field = $request->input('field', 'name');
        $direction = $request->input('direction', 'asc');

        $carProducts = CarProduct::with('type')->orderBy($field, $direction)->get();
        $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;

        return response()->json([
            'success' => true,
            'html' => view('car-products.table', compact('carProducts', 'employee'))->render()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'type_id' => 'required|exists:car_product_types,id'
        ]);

        $carProduct = CarProduct::create($validated);

        if ($request->expectsJson()) {
            $carProducts = CarProduct::with('type')->get();
            $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;
            return response()->json([
                'success' => true,
                'message' => 'Car product added successfully.',
                'html' => view('car-products.table', compact('carProducts', 'employee'))->render()
            ]);
        }

        return redirect()->route('car-products.index')->with('success', 'Car product added successfully.');
    }

    public function update(Request $request, CarProduct $carProduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'type_id' => 'required|exists:car_product_types,id'
        ]);

        $carProduct->update($validated);

        if ($request->expectsJson()) {
            $carProducts = CarProduct::with('type')->get();
            $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;
            return response()->json([
                'success' => true,
                'message' => 'Car product updated successfully.',
                'html' => view('car-products.table', compact('carProducts', 'employee'))->render()
            ]);
        }

        return redirect()->route('car-products.index')->with('success', 'Car product updated successfully.');
    }

    public function destroy(CarProduct $carProduct)
    {
        $carProduct->delete();

        if (request()->expectsJson()) {
            $carProducts = CarProduct::with('type')->get();
            $employee = Auth::guard('employee')->user() ? Auth::guard('employee')->user()->load('jobTitle') : null;
            return response()->json([
                'success' => true,
                'message' => 'Car product deleted successfully.',
                'html' => view('car-products.table', compact('carProducts', 'employee'))->render()
            ]);
        }

        return redirect()->route('car-products.index')->with('success', 'Car product deleted successfully.');
    }
}
