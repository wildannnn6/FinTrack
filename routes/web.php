<?php

use App\Http\Controllers\HomeStandardController;
use App\Http\Controllers\HomeAdvanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login.index');
})->name('home');

// Auth Routes
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/auth', [SignupController::class, 'signup'])->name('signup.auth');

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Public Pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/testimonial', function () {
    $testimonials = [
        [
            'name' => 'Ahmad Rizki',
            'position' => 'Freelancer',
            'content' => 'Fintrack membantu saya mengelola keuangan dengan sangat baik.',
            'rating' => 5
        ],
        [
            'name' => 'Sari Dewi', 
            'position' => 'Business Owner',
            'content' => 'Sebagai pemilik bisnis, Fintrack memberikan insight yang valuable.',
            'rating' => 5
        ]
    ];
    return view('pages.testimonial', compact('testimonials'));
})->name('testimonial');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/features', function () {
    $features = [
        ['icon' => '📊', 'title' => 'Analisis Keuangan', 'description' => 'Analisis mendalam pengeluaran dan pemasukan.'],
        ['icon' => '🎯', 'title' => 'Prioritas Eisenhower', 'description' => 'Kelola pengeluaran berdasarkan prioritas.'],
        ['icon' => '💰', 'title' => 'Manajemen Budget', 'description' => 'Atur anggaran dengan mudah.'],
        ['icon' => '📈', 'title' => 'Laporan Detail', 'description' => 'Laporan keuangan profesional.']
    ];
    return view('pages.features', compact('features'));
})->name('features');

// Protected Routes - Standard User
Route::get('/home-standard', [HomeStandardController::class, 'index'])->name('home.standard');
Route::resource('transactions', TransactionController::class);
Route::resource('savings', SavingsController::class);
Route::post('/export-data', [ReportController::class, 'exportBasic'])->name('export.basic');

// Protected Routes - Advance User  
Route::get('/home-advance', [HomeAdvanceController::class, 'index'])->name('home.advance');
Route::resource('budgets', BudgetController::class);
Route::resource('investments', InvestmentController::class);
Route::resource('debts', DebtController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/export-advance', [ReportController::class, 'exportAdvance'])->name('export.advance');
Route::get('/cash-flow', [ReportController::class, 'cashFlow'])->name('cashflow');
Route::get('/tax-planning', [ReportController::class, 'taxPlanning'])->name('tax.planning');

// Protected Routes - Admin
Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
Route::get('/admin/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');

// Logout
Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('login.index')->with('success', 'Logout berhasil!');
})->name('logout');