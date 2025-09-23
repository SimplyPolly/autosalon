<?php

namespace App\Exports;

use App\Models\RepairWork;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RepairsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return RepairWork::with(['car.brand', 'car.model', 'mechanic', 'status'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Автомобиль',
            'Механик',
            'Описание',
            'Дата начала',
            'Дата завершения',
            'Статус',
            'Стоимость',
            'Дата создания',
        ];
    }

    public function map($repairWork): array
    {
        return [
            $repairWork->id,
            $repairWork->car->brand->name . ' ' . $repairWork->car->model->name,
            $repairWork->mechanic->first_name . ' ' . $repairWork->mechanic->last_name,
            $repairWork->description,
            $repairWork->repair_date,
            $repairWork->completion_date,
            $repairWork->status->name,
            $repairWork->cost,
            $repairWork->created_at,
        ];
    }
} 