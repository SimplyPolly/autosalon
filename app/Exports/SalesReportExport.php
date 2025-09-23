<?php

namespace App\Exports;

use App\Models\Deal;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Deal::select(
            DB::raw("DATE_TRUNC('month', \"Дата_сделки\") as month"),
            DB::raw("COUNT(*) as total_deals"),
            DB::raw("SUM(\"Сумма_сделки\") as total_amount")
        )
        ->where('Статус_сделки', 'Завершена')
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();
    }

    public function headings(): array
    {
        return ['Месяц', 'Всего сделок', 'Общая сумма'];
    }
}