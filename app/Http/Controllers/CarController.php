<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use App\Models\CarStatus;
use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CarBrands;
use App\Models\CarModels;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Метод для отображения списка автомобилей
    public function index()
    {
        $query = Cars::with(['brand', 'model', 'status', 'salon']);

        // Если пользователь не является сотрудником (то есть клиент или не авторизованный пользак), фильтр "В наличии"
        if (!Auth::guard('employee')->check()) {
            $query->whereHas('status', function ($q) {
                $q->where('name', 'В наличии');
            });
        }

        $cars = $query->get();

        $salons = Salon::all();

        return view('cars.index', compact('cars', 'salons'));
    }

    // Метод для отображения формы создания нового автомобиля
    public function create()
    {
        $salons = Salon::all();
        $carBrands = CarBrands::all();
        $carModels = CarModels::all();
        $carStatuses = Auth::guard('employee')->check() ? CarStatus::all() : collect();

        return view('cars.create', compact('salons', 'carBrands', 'carModels', 'carStatuses'));
    }

    // Метод для хранения нового автомобиля в базе данных
    public function store(Request $request)
    {
        $rules = [
            'salon_id'=> 'required|exists:salon,id', 
            'brand_id' => 'required|exists:car_brands,id', 
            'model_id'=> 'required|exists:car_models,id',
            'status_id'=> 'required|exists:car_status,id',
            'vin' => 'required|string|unique:cars,vin', 
            'registration_number' => 'required|string|unique:cars,registration_number', 
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1), 
            'color' => 'required|string|exist:cars,color', 
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|string|exists:cars,mileage', 
            'description' => 'required|string|exist:cars,description', 
            'car_option' => 'required|string|exist:cars,car_option',
        ];

        // Если пользователь является сотрудником, добавляем валидацию для id_статуса
        if (Auth::guard('employee')->check()) {
            $rules['status_id'] = 'required|exists:car_statuses,id';
        }

        $validated = $request->validate($rules);

        // Если пользователь не является сотрудником, устанавливаем id_статуса в "В наличии"
        if (!Auth::guard('employee')->check()) {
            $validated['status_id'] = CarStatus::where('name', 'В наличии')->first()->id ?? 1;
        }

        $car = Cars::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Автомобиль успешно добавлен');
    }

    // Метод для отображения формы редактирования автомобиля
    public function edit(Cars $car)
    {
        $salons = Salon::all();
        $carBrands = CarBrands::all();
        $carModels = CarModels::all();
        $carStatuses = CarStatus::all();

        return view('cars.edit', compact( 'car','salons', 'carBrands', 'carModels', 'carStatuses'));
    }

    // Метод для обновления автомобиля в базе данных
    public function update(Request $request, $id)
    {
        $rules = [
            'salon_id'=> 'required|exists:salon,id', 
            'brand_id' => 'required|exists:car_brands,id', 
            'model_id'=> 'required|exists:car_models,id',
            'status_id'=> 'required|exists:car_status,id',
            'vin' => 'required|string|unique:cars,vin', 
            'registration_number' => 'required|string|unique:cars,registration_number', 
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1), 
            'color' => 'required|string|max:255', 
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|string|max:255', 
            'description' => 'required|string', 
            'car_option' => 'required|string',
        ];

        // Если пользователь является сотрудником, добавляем валидацию для id_статуса
        if (Auth::guard('employee')->check()) {
            $rules['status_id'] = 'required|exists:car_statuses,id';
        }

        $validated = $request->validate($rules);

        $car = Cars::findOrFail($id);

        $car->update($validated);

        return redirect()->route('cars.index')->with('success', 'Автомобиль успешно обновлён!');
    }

    // Метод для удаления автомобиля из базы данных
    public function destroy($id)
    {
        $car = Cars::findOrFail($id);

        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Автомобиль успешно удален!');
    }

    // Метод для отображения подробной инфы об авто
    public function show($id)
    {
        $car = Cars::with(['brand', 'model', 'status', 'salon'])->findOrFail($id);
        return view('cars.show', compact('car'));
    }

    // Метод для фильтра авто поиск/фильтры
    public function search(Request $request)
    {
        $query = $request->get('search', '');
        $filters = $request->only([
            'brand',
            'model',
            'yearFrom',
            'yearTo',
            'priceFrom',
            'priceTo',
            'color',
            'salon'
        ]);

        $cars = Cars::with(['brand', 'model', 'status', 'salon']);

        // Если пользователь не является сотрудником, фильтруем по статусу "В наличии"
        if (!Auth::guard('employee')->check()) {
            $cars->whereHas('status', function ($q) {
                $q->where('name', 'В наличии');
            });
        }

        // Применяем текстовый поиск
        if (!empty($query)) {
            $cars->where(function($q) use ($query) {
                $q->whereHas('brand', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhereHas('model', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                });
            });
        }

        // Применяем фильтры
        if (!empty($filters['brand'])) {
            $cars->where('brand_id', $filters['brand']);
        }

        if (!empty($filters['model'])) {
            $cars->where('model_id', $filters['model']);
        }

        if (!empty($filters['yearFrom'])) {
            $cars->where('year', '>=', $filters['yearFrom']);
        }

        if (!empty($filters['yearTo'])) {
            $cars->where('year', '<=', $filters['yearTo']);
        }

        if (!empty($filters['priceFrom'])) {
            $cars->where('price', '>=', $filters['priceFrom']);
        }

        if (!empty($filters['priceTo'])) {
            $cars->where('price', '<=', $filters['priceTo']);
        }

        if (!empty($filters['color'])) {
            $cars->where('color', '=', $filters['color']);
        }

        if (!empty($filters['status'])) {
            $cars->whereHas('status', function ($q) use ($filters) {
                $q->where('name', $filters['status']);
            });
        }

        if (!empty($filters['salon'])) {
            $cars->where('salon_id', $filters['salon']);
        }

        $cars = $cars->get();

        return response()->json([
            'success' => true,
            'html' => view('cars.table', compact('cars'))->render(),
        ]);
    }
}
