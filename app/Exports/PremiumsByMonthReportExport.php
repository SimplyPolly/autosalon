<?php

namespace App\Exports;

use App\Models\Premium;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PremiumsByMonthReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Premium::select(
            DB::raw("DATE_TRUNC('month', \"Дата_выплаты\") as month"),
            DB::raw("COUNT(*) as total_premiums"),
            DB::raw("SUM(\"Сумма\") as total_amount"),
            DB::raw("AVG(\"Сумма\") as avg_amount")
        )
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();
    }

    public function headings(): array
    {
        return ['Месяц', 'Всего премий', 'Общая сумма', 'Средняя сумма'];
    }
}