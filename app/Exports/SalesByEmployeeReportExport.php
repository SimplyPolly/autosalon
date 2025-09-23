<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesByEmployeeReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::select(
            '"Сотрудники"."ФИО"',
            DB::raw('COUNT(deals."id_сделки") as total_deals'),
            DB::raw('SUM(deals."Сумма_сделки") as total_amount')
        )
        ->join('deals', '"Сотрудники"."id_сотрудника"', '=', 'deals."id_сотрудника"')
        ->where('deals."Статус_сделки"', 'Завершена')
        ->groupBy('"Сотрудники"."ФИО"')
        ->orderBy('total_amount', 'desc')
        ->get();
    }

    public function headings(): array
    {
        return ['Сотрудник', 'Всего сделок', 'Общая сумма'];
    }
}