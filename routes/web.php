<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Exports\RecordsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('indexhome');
});

Route::get('/wow', function () {
    return view('theinvoicehtml');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// invoice controller routes
Route::middleware(['auth'])->group(function () {
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::get('/invoices/create2', [InvoiceController::class, 'create2'])->name('invoices.create2');
    Route::get('/invoices', [InvoiceController::class, 'payform'])->name('invoices.payform');
    Route::get('/statement', [InvoiceController::class, 'statementform'])->name('invoices.statementform');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::post('/invoices/store2', [InvoiceController::class, 'store2'])->name('invoices.store2');
    Route::post('/statement/import', [InvoiceController::class, 'uploadExcel'])->name('invoices.uploadExcel');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/invoices/download2', [InvoiceController::class, 'download2'])->name('invoices.download2');
    Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::get('/invoices/export', [InvoiceController::class, 'exportexcel'])->name('invoices.exportexcel');
    Route::delete('/statement/clear', [InvoiceController::class, 'clear'])->name('statements.clear');
});
