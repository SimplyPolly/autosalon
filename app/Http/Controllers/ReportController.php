<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Car;
use App\Models\Employee;
use App\Models\RepairWork;
use App\Models\Salary;
use App\Models\Premium;
use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

// Подключаем Export-классы, которые ты создашь в app/Exports/
use App\Exports\SalesReportExport;
use App\Exports\TopCarsReportExport;
use App\Exports\SalesByEmployeeReportExport;
use App\Exports\SalariesByMonthReportExport;
use App\Exports\PremiumsByMonthReportExport;
use App\Exports\SalesExport;
use App\Exports\RepairsExport;
use App\Exports\SalaryExport;

class ReportController extends Controller
{
    public function sales()
    {
        // Статистика по месяцам
        $salesData = DB::table('deals')
            ->select(
                DB::raw('DATE_TRUNC(\'month\', date) as month'),
                DB::raw('COUNT(*) as total_deals'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('type', 'sale')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Лучшие продажи по автомобилям
        $topCars = DB::table('deals')
            ->join('cars', 'deals.car_id', '=', 'cars.id')
            ->join('car_brands', 'cars.brand_id', '=', 'car_brands.id')
            ->join('car_models', 'cars.model_id', '=', 'car_models.id')
            ->select(
                'car_brands.name as brand',
                'car_models.name as model',
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(deals.amount) as total_amount')
            )
            ->where('deals.type', 'sale')
            ->groupBy('car_brands.name', 'car_models.name')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();

        // Продажи по сотрудникам
        $salesByEmployee = DB::table('deals')
            ->join('employees', 'deals.employee_id', '=', 'employees.id')
            ->select(
                DB::raw('CONCAT(employees.last_name, \' \', employees.first_name, \' \', COALESCE(employees.middle_name, \'\')) as full_name'),
                DB::raw('COUNT(*) as total_deals'),
                DB::raw('SUM(deals.amount) as total_amount')
            )
            ->where('deals.type', 'sale')
            ->groupBy('employees.last_name', 'employees.first_name', 'employees.middle_name')
            ->orderBy('total_amount', 'desc')
            ->get();

        return view('admin.reports.sales', [
            'salesData' => $salesData,
            'topCars' => $topCars,
            'salesByEmployee' => $salesByEmployee
        ]);
    }

    public function inventory()
    {
        $inventoryData = Car::select(
            'car_statuses.name as status',
            DB::raw('COUNT(*) as total_cars')
        )
            ->join('car_statuses', 'cars.status_id', '=', 'car_statuses.id')
            ->groupBy('car_statuses.name')
            ->get();

        return view('admin.reports.inventory', compact('inventoryData'));
    }

    public function employees()
    {
        // Get employee performance
        $employeePerformance = Employee::select(
            'Сотрудники.ФИО',
            'Должности.Название_должности',
            DB::raw('COUNT(deals.id_сделки) as total_deals'),
            DB::raw('SUM(deals.Сумма_сделки) as total_sales'),
            DB::raw('AVG(deals.Сумма_сделки) as avg_deal_amount')
        )
            ->join('Должности', 'Сотрудники.id_должности', '=', 'Должности.id_должности')
            ->leftJoin('deals', 'Сотрудники.id_сотрудника', '=', 'deals.id_сотрудника')
            ->where('deals.Статус_сделки', 'Завершена')
            ->groupBy('Сотрудники.ФИО', 'Должности.Название_должности')
            ->orderBy('total_sales', 'desc')
            ->get();

        // Get employee salary statistics
        $salaryStats = Employee::select(
            'Должности.Название_должности',
            DB::raw('COUNT(*) as total_employees'),
            DB::raw('AVG(Сотрудники.Оклад) as avg_salary'),
            DB::raw('MIN(Сотрудники.Оклад) as min_salary'),
            DB::raw('MAX(Сотрудники.Оклад) as max_salary')
        )
            ->join('Должности', 'Сотрудники.id_должности', '=', 'Должности.id_должности')
            ->groupBy('Должности.Название_должности')
            ->get();

        return view('admin.reports.employees', compact('employeePerformance', 'salaryStats'));
    }

    public function repairs()
    {
        // Статистика по месяцам
        $repairData = DB::table('repair_works')
            ->select(
                DB::raw("DATE_TRUNC('month', created_at) as month"),
                DB::raw('COUNT(*) as total_repairs'),
                DB::raw('SUM(cost) as total_cost'),
                DB::raw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_repairs")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Статистика по статусам
        $statusStats = DB::table('repair_works')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Статистика по механикам
        $mechanicStats = DB::table('repair_works')
            ->join('employees', 'repair_works.employee_id', '=', 'employees.id')
            ->select(
                'employees.first_name',
                'employees.last_name',
                DB::raw('COUNT(*) as total_repairs'),
                DB::raw('SUM(repair_works.cost) as total_cost'),
                DB::raw("SUM(CASE WHEN repair_works.status = 'completed' THEN 1 ELSE 0 END) as completed_repairs")
            )
            ->groupBy('employees.first_name', 'employees.last_name')
            ->orderBy('total_repairs', 'desc')
            ->get();

        return view('admin.reports.repairs', [
            'repairData' => $repairData,
            'statusStats' => $statusStats,
            'mechanicStats' => $mechanicStats
        ]);
    }

    public function salary()
    {
        // Статистика по месяцам
        $salaryData = DB::table('salaries')
            ->select(
                DB::raw('DATE_TRUNC(\'month\', payment_date) as month'),
                DB::raw('COUNT(*) as total_payments'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Статистика по должностям
        $positionStats = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select(
                'job_titles.title',
                DB::raw('COUNT(DISTINCT employees.id) as total_employees'),
                DB::raw('SUM(salaries.amount) as total_amount'),
                DB::raw('AVG(salaries.amount) as avg_salary')
            )
            ->groupBy('job_titles.title')
            ->get();

        return view('admin.reports.salary', [
            'salaryData' => $salaryData,
            'salaryByPosition' => $positionStats
        ]);
    }

    // === ЭКСПОРТ ОТЧЁТОВ В EXCEL ===

    public function exportSalesReport()
    {
        return Excel::download(new SalesReportExport(), 'sales_report.xlsx');
    }

    public function exportTopCarsReport()
    {
        return Excel::download(new TopCarsReportExport(), 'top_cars_report.xlsx');
    }

    public function exportSalesByEmployeeReport()
    {
        return Excel::download(new SalesByEmployeeReportExport(), 'sales_by_employee_report.xlsx');
    }

    public function exportSalariesByMonthReport()
    {
        return Excel::download(new SalariesByMonthReportExport(), 'salaries_by_month_report.xlsx');
    }

    public function exportPremiumsByMonthReport()
    {
        return Excel::download(new PremiumsByMonthReportExport(), 'premiums_by_month_report.xlsx');
    }

    public function exportSales()
    {
        return Excel::download(new SalesExport, 'sales-report.xlsx');
    }

    public function exportRepairs()
    {
        return Excel::download(new RepairsExport, 'repairs-report.xlsx');
    }

    public function exportSalary()
    {
        return Excel::download(new SalaryExport, 'salary-report.xlsx');
    }
}