<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\RepairWork;
use App\Models\Salary;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $deals = Deal::whereBetween('created_at', [$startDate, $endDate])
            ->with(['car', 'client', 'employee'])
            ->get();

        $reportData = [
            'headers' => ['ID', 'Дата', 'Автомобиль', 'Клиент', 'Сотрудник', 'Сумма'],
            'rows' => []
        ];

        foreach ($deals as $deal) {
            $reportData['rows'][] = [
                $deal->id,
                $deal->created_at->format('d.m.Y'),
                $deal->car->model->brand->name . ' ' . $deal->car->model->name,
                $deal->client->name,
                $deal->employee->name,
                number_format($deal->amount, 2) . ' ₽'
            ];
        }

        return view('reports.index', compact('reportData'));
    }

    public function repairs(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $repairs = RepairWork::whereBetween('created_at', [$startDate, $endDate])
            ->with(['car', 'client', 'employee'])
            ->get();

        $reportData = [
            'headers' => ['ID', 'Дата', 'Автомобиль', 'Клиент', 'Сотрудник', 'Стоимость'],
            'rows' => []
        ];

        foreach ($repairs as $repair) {
            $reportData['rows'][] = [
                $repair->id,
                $repair->created_at->format('d.m.Y'),
                $repair->car->model->brand->name . ' ' . $repair->car->model->name,
                $repair->client->name,
                $repair->employee->name,
                number_format($repair->cost, 2) . ' ₽'
            ];
        }

        return view('reports.index', compact('reportData'));
    }

    public function salaries(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $salaries = Salary::where('month', $month)
            ->where('year', $year)
            ->with('employee')
            ->get();

        $reportData = [
            'headers' => ['ID', 'Сотрудник', 'Базовая ставка', 'Премия', 'Итого'],
            'rows' => []
        ];

        foreach ($salaries as $salary) {
            $reportData['rows'][] = [
                $salary->id,
                $salary->employee->name,
                number_format($salary->base_salary, 2) . ' ₽',
                number_format($salary->premium, 2) . ' ₽',
                number_format($salary->base_salary + $salary->premium, 2) . ' ₽'
            ];
        }

        return view('reports.index', compact('reportData'));
    }

    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $deals = Deal::whereBetween('created_at', [$startDate, $endDate])
            ->with(['car', 'client', 'employee'])
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Заголовки
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Дата');
        $sheet->setCellValue('C1', 'Автомобиль');
        $sheet->setCellValue('D1', 'Клиент');
        $sheet->setCellValue('E1', 'Сотрудник');
        $sheet->setCellValue('F1', 'Сумма');

        $row = 2;
        foreach ($deals as $deal) {
            $sheet->setCellValue('A' . $row, $deal->id);
            $sheet->setCellValue('B' . $row, $deal->created_at->format('d.m.Y'));
            $sheet->setCellValue('C' . $row, $deal->car->model->brand->name . ' ' . $deal->car->model->name);
            $sheet->setCellValue('D' . $row, $deal->client->name);
            $sheet->setCellValue('E' . $row, $deal->employee->name);
            $sheet->setCellValue('F' . $row, number_format($deal->amount, 2) . ' ₽');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'sales_report_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

    public function exportRepairs(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $repairs = RepairWork::whereBetween('created_at', [$startDate, $endDate])
            ->with(['car', 'client', 'employee'])
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Заголовки
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Дата');
        $sheet->setCellValue('C1', 'Автомобиль');
        $sheet->setCellValue('D1', 'Клиент');
        $sheet->setCellValue('E1', 'Сотрудник');
        $sheet->setCellValue('F1', 'Стоимость');

        $row = 2;
        foreach ($repairs as $repair) {
            $sheet->setCellValue('A' . $row, $repair->id);
            $sheet->setCellValue('B' . $row, $repair->created_at->format('d.m.Y'));
            $sheet->setCellValue('C' . $row, $repair->car->model->brand->name . ' ' . $repair->car->model->name);
            $sheet->setCellValue('D' . $row, $repair->client->name);
            $sheet->setCellValue('E' . $row, $repair->employee->name);
            $sheet->setCellValue('F' . $row, number_format($repair->cost, 2) . ' ₽');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'repairs_report_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

    public function exportSalaries(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $salaries = Salary::where('month', $month)
            ->where('year', $year)
            ->with('employee')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Заголовки
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Сотрудник');
        $sheet->setCellValue('C1', 'Базовая ставка');
        $sheet->setCellValue('D1', 'Премия');
        $sheet->setCellValue('E1', 'Итого');

        $row = 2;
        foreach ($salaries as $salary) {
            $sheet->setCellValue('A' . $row, $salary->id);
            $sheet->setCellValue('B' . $row, $salary->employee->name);
            $sheet->setCellValue('C' . $row, number_format($salary->base_salary, 2) . ' ₽');
            $sheet->setCellValue('D' . $row, number_format($salary->premium, 2) . ' ₽');
            $sheet->setCellValue('E' . $row, number_format($salary->base_salary + $salary->premium, 2) . ' ₽');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'salaries_report_' . $year . '_' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
} 