<?php

namespace App\Exports;

use App\Models\Salary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalaryExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Salary::with(['employee.jobTitle'])
            ->orderBy('payment_date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Сотрудник',
            'Должность',
            'Сумма',
            'Дата выплаты',
            'Тип выплаты',
        ];
    }

    public function map($salary): array
    {
        return [
            $salary->id,
            $salary->employee->first_name . ' ' . $salary->employee->last_name,
            $salary->employee->jobTitle->title,
            $salary->amount,
            $salary->payment_date,
            $salary->payment_type,
        ];
    }
} 