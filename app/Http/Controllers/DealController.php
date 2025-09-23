<?php

namespace App\Http\Controllers;

use App\Models\Deals;
use App\Models\Cars;
use App\Models\CarProducts;
use App\Models\Clients;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deals::with(['car', 'product', 'client', 'employee'])->get();
        return view('admin.deals.index', compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Cars::where('status_id', 1)->get(); // Only available cars
        $products = CarProducts::where('stock', '>', 0)->get(); // Only products in stock
        $clients = Clients::all();
        $employees = Employee::all();

        return view('admin.deals.create', compact('cars', 'products', 'clients', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'nullable|exists:cars,id',
            'product_id' => 'nullable|exists:car_products,id',
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string'
        ]);

        // Ensure at least one of car_id or product_id is provided
        if (empty($validated['car_id']) && empty($validated['product_id'])) {
            return back()->withErrors(['error' => 'Either a car or a product must be selected']);
        }

        $deal = Deals::create($validated);

        // Update car status if a car was sold
        if (!empty($validated['car_id'])) {
            $car = Cars::find($validated['car_id']);
            $car->update(['status_id' => 2]); // Assuming 2 is the ID for "Sold" status
        }

        // Update product stock if a product was sold
        if (!empty($validated['product_id'])) {
            $product = CarProducts::find($validated['product_id']);
            $product->decrement('stock');
        }

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deals $deal)
    {
        $deal->load(['car', 'product', 'client', 'employee']);
        return view('admin.deals.show', compact('deal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deals $deal)
    {
        $cars = Cars::where('status_id', 1)->orWhere('id', $deal->car_id)->get();
        $products = CarProducts::where('stock', '>', 0)->orWhere('id', $deal->product_id)->get();
        $clients = Clients::all();
        $employees = Employee::all();

        return view('admin.deals.edit', compact('deal', 'cars', 'products', 'clients', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deals $deal)
    {
        $validated = $request->validate([
            'car_id' => 'nullable|exists:cars,id',
            'product_id' => 'nullable|exists:car_products,id',
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string'
        ]);

        // Ensure at least one of car_id or product_id is provided
        if (empty($validated['car_id']) && empty($validated['product_id'])) {
            return back()->withErrors(['error' => 'Either a car or a product must be selected']);
        }

        // Handle car status changes
        if ($deal->car_id != $validated['car_id']) {
            if ($deal->car_id) {
                $oldCar = Cars::find($deal->car_id);
                $oldCar->update(['status_id' => 1]); // Return to available
            }
            if ($validated['car_id']) {
                $newCar = Cars::find($validated['car_id']);
                $newCar->update(['status_id' => 2]); // Mark as sold
            }
        }

        // Handle product stock changes
        if ($deal->product_id != $validated['product_id']) {
            if ($deal->product_id) {
                $oldProduct = CarProducts::find($deal->product_id);
                $oldProduct->increment('stock');
            }
            if ($validated['product_id']) {
                $newProduct = CarProducts::find($validated['product_id']);
                $newProduct->decrement('stock');
            }
        }

        $deal->update($validated);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deals $deal)
    {
        // Return car to available status if it was part of the deal
        if ($deal->car_id) {
            $car = Cars::find($deal->car_id);
            $car->update(['status_id' => 1]);
        }

        // Return product to stock if it was part of the deal
        if ($deal->product_id) {
            $product = CarProducts::find($deal->product_id);
            $product->increment('stock');
        }

        $deal->delete();

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal successfully deleted');
    }
} 