<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarProductsController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RepairWorkController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CarOptionController;
use App\Http\Controllers\CarStatusController;
use App\Http\Controllers\CarProductTypeController;
use App\Http\Controllers\UpdateEmployeePasswordsController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ConsultationRequestController;
use App\Http\Controllers\Admin\DashboardController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');

// Public Routes
Route::get('/cars/search', [CarController::class, 'search'])->name('cars.search');
Route::get('/cars/sort', [CarController::class, 'sort'])->name('cars.sort');
Route::get('/cars/export/excel', [CarController::class, 'exportExcel'])->name('cars.export.excel');
Route::get('/cars/export/pdf', [CarController::class, 'exportPDF'])->name('cars.export.pdf');
Route::resource('cars', CarController::class)->only(['index', 'show']);

// Car Products Routes
Route::get('/car-products/search', [CarProductsController::class, 'search'])->name('car-products.search');
Route::get('/car-products/sort', [CarProductsController::class, 'sort'])->name('car-products.sort');
Route::resource('car-products', CarProductsController::class)->only(['index', 'show']);

// API routes for filter data
Route::get('/api/car-brands', [CarBrandController::class, 'getAll']);
Route::get('/api/car-models/{brandId}', [CarModelController::class, 'getByBrand']);
Route::get('/api/car-statuses', [CarStatusController::class, 'getAll']);
Route::get('/api/salons', [SalonController::class, 'getAll']);

// Client Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('deals', DealController::class)->only(['index', 'store', 'show']);

    // Consultation Requests for Clients
    Route::resource('consultation-requests', ConsultationRequestController::class)->only(['create', 'store']);
});

// Employee Routes
Route::middleware(['auth:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', function () {
        return view('employee.dashboard');
    })->name('dashboard');

    Route::resource('cars', CarController::class)->except(['index', 'show']);
    Route::resource('car-products', CarProductsController::class)->except(['index', 'show']);
    
    Route::resource('deals', DealController::class)->except(['index', 'show']);

    Route::resource('repair-works', RepairWorkController::class);
    
    Route::resource('consultation-requests', ConsultationRequestController::class)->except(['create', 'store']);
    Route::post('/consultation-requests/{consultationRequest}/take-in-work', [ConsultationRequestController::class, 'takeInWork'])->name('consultation-requests.take-in-work');
    
    Route::resource('salary', SalaryController::class)->only(['index']);
    Route::resource('premiums', PremiumController::class)->only(['index']);
});

// Admin Routes
Route::middleware(['auth:employee', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('employees', EmployeeController::class);
    Route::resource('salaries', SalaryController::class);
    Route::resource('premiums', PremiumController::class);
    Route::resource('users', UserController::class);
    Route::resource('cars', CarController::class);
    Route::resource('deals', DealController::class);
    Route::resource('car-brands', CarBrandController::class);
    Route::resource('car-models', CarModelController::class);
    Route::resource('car-options', CarOptionController::class);
    Route::resource('car-statuses', CarStatusController::class);
    Route::resource('car-product-types', CarProductTypeController::class);
    Route::resource('car-products', CarProductsController::class);
    Route::resource('consultation-requests', ConsultationRequestController::class)->only(['destroy']);
    Route::resource('salons', SalonController::class);
    Route::resource('job-titles', JobTitleController::class);

    // Routes for modal forms
    Route::get('/car-brands/create-modal', [CarBrandController::class, 'createModal'])->name('car-brands.create_modal');
    Route::get('/car-models/create-modal', [CarModelController::class, 'createModal'])->name('car-models.create_modal');
    Route::get('/car-statuses/create-modal', [CarStatusController::class, 'createModal'])->name('car-statuses.create_modal');
    Route::get('/salons/create-modal', [SalonController::class, 'createModal'])->name('salons.create_modal');

    // Reports routes
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
    Route::get('/reports/repairs', [ReportController::class, 'repairs'])->name('reports.repairs');
    Route::get('/reports/salary', [ReportController::class, 'salary'])->name('reports.salary');
});

// Экспорт отчётов
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/reports/sales/export', [ReportController::class, 'exportSalesReport'])->name('reports.sales.export');
    Route::get('/reports/top-cars/export', [ReportController::class, 'exportTopCarsReport'])->name('reports.top-cars.export');
    Route::get('/reports/sales-by-employee/export', [ReportController::class, 'exportSalesByEmployeeReport'])->name('reports.sales-by-employee.export');
    Route::get('/reports/salaries-by-month/export', [ReportController::class, 'exportSalariesByMonthReport'])->name('reports.salaries-by-month.export');
    Route::get('/reports/premiums-by-month/export', [ReportController::class, 'exportPremiumsByMonthReport'])->name('reports.premiums-by-month.export');
});

// Маршруты для отчетов
Route::middleware(['web', 'auth:employee', 'admin'])->group(function () {
    Route::get('/admin/reports/sales', [ReportController::class, 'sales'])->name('admin.reports.sales');
    Route::get('/admin/reports/repairs', [ReportController::class, 'repairs'])->name('admin.reports.repairs');
    Route::get('/admin/reports/salary', [ReportController::class, 'salary'])->name('admin.reports.salary');
    
    // Маршруты для экспорта
    Route::get('/admin/reports/sales/export', [ReportController::class, 'exportSales'])->name('admin.reports.sales.export');
    Route::get('/admin/reports/repairs/export', [ReportController::class, 'exportRepairs'])->name('admin.reports.repairs.export');
    Route::get('/admin/reports/salary/export', [ReportController::class, 'exportSalary'])->name('admin.reports.salary.export');

    // Маршруты для ремонтных работ
    Route::get('/admin/repair-works', [RepairWorkController::class, 'index'])->name('repair-works.index');
    Route::get('/admin/repair-works/create', [RepairWorkController::class, 'create'])->name('repair-works.create');
    Route::post('/admin/repair-works', [RepairWorkController::class, 'store'])->name('repair-works.store');
    Route::get('/admin/repair-works/{repairWork}/edit', [RepairWorkController::class, 'edit'])->name('repair-works.edit');
    Route::put('/admin/repair-works/{repairWork}', [RepairWorkController::class, 'update'])->name('repair-works.update');
    Route::delete('/admin/repair-works/{repairWork}', [RepairWorkController::class, 'destroy'])->name('repair-works.destroy');
    Route::get('/admin/repair-works/export', [RepairWorkController::class, 'export'])->name('repair-works.export');
});

// Маршруты для управления ремонтными работами
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/repair-works', [RepairWorkController::class, 'index'])->name('repair-works.index');
    Route::get('/repair-works/create', [RepairWorkController::class, 'create'])->name('repair-works.create');
    Route::post('/repair-works', [RepairWorkController::class, 'store'])->name('repair-works.store');
    Route::get('/repair-works/{repairWork}/edit', [RepairWorkController::class, 'edit'])->name('repair-works.edit');
    Route::put('/repair-works/{repairWork}', [RepairWorkController::class, 'update'])->name('repair-works.update');
    Route::delete('/repair-works/{repairWork}', [RepairWorkController::class, 'destroy'])->name('repair-works.destroy');
    Route::get('/repair-works/export', [RepairWorkController::class, 'export'])->name('repair-works.export');
});
