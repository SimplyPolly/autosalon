<?php

namespace App\Exports;

use App\Models\Cars;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopCarsReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Cars::select(
            'cars."Марка"',
            'cars."Модель"',
            DB::raw('COUNT(deals."id_сделки") as total_sales'),
            DB::raw('SUM(deals."Сумма_сделки") as total_revenue')
        )
        ->join('deals', 'cars."id_автомобиля"', '=', 'deals."id_автомобиля"')
        ->where('deals."Статус_сделки"', 'Завершена')
        ->groupBy('cars."Марка"', 'cars."Модель"')
        ->orderBy('total_sales', 'desc')
        ->limit(10)
        ->get();
    }

    public function headings(): array
    {
        return ['Марка', 'Модель', 'Количество продаж', 'Общая выручка'];
    }
}