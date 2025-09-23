<?php

namespace App\Exports;

use App\Models\Deal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Deal::with(['car.brand', 'car.model', 'client', 'employee'])
            ->where('status_id', 3)
            ->orderBy('date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Дата',
            'Автомобиль',
            'Клиент',
            'Менеджер',
            'Сумма',
            'Статус',
        ];
    }

    public function map($deal): array
    {
        return [
            $deal->id,
            $deal->date,
            $deal->car->brand->name . ' ' . $deal->car->model->name,
            $deal->client->first_name . ' ' . $deal->client->last_name,
            $deal->employee->first_name . ' ' . $deal->employee->last_name,
            $deal->amount,
            $deal->status->name,
        ];
    }
} 