<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index()
    {
        $salons = Salon::get();
        return view('admin.salons.index', compact('salons'));
    }

    public function create()
    {
        return view('admin.salons.create');
    }

    // Method to return a partial view for modal form
    public function createModal()
    {
        return view('admin.salons.create_modal');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:salons,name',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:salons,email',
        ]);

        $salon = Salon::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Салон успешно добавлен.',
                'new_id' => $salon->id,
                'new_text' => $salon->name,
                'select_id' => 'salon_id'
            ]);
        }

        return redirect()->route('admin.salons.index')
            ->with('success', 'Салон успешно добавлен.');
    }

    public function show(Salon $salon)
    {
        return view('admin.salons.show', compact('salon'));
    }

    public function edit(Salon $salon)
    {
        return view('admin.salons.edit', compact('salon'));
    }

    public function update(Request $request, Salon $salon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:salons,name,' . $salon->id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:salons,email,' . $salon->id,
        ]);

        $salon->update($validated);

        return redirect()->route('admin.salons.index')
            ->with('success', 'Салон успешно обновлен.');
    }

    public function destroy(Salon $salon)
    {
        $salon->delete();

        return redirect()->route('admin.salons.index')
            ->with('success', 'Салон успешно удален.');
    }

    public function getAll()
    {
        $salons = Salon::all();
        return response()->json($salons);
    }
} 