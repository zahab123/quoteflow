<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationStatusController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;


    Route::get('/', function () {
        return view('welcome');
    });

    // Authenticated routes
    Route::middleware(['auth', 'verified'])->group(function () {

    // Normal User Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clients CRUD
    Route::get('/client', function () {
        return view('client');
    });
    Route::post('/client', [ClientController::class, 'addclient'])->name('addclient');
    Route::get('/clientlist', [ClientController::class, 'clientlist'])->name('clientlist');
    Route::get('/updateclient/{id}', [ClientController::class, 'updateclient'])->name('updateclient');
    Route::post('/updateclient/{id}', [ClientController::class, 'postupdateclient'])->name('postupdateclient');
    Route::get('/deleteclient/{id}', [ClientController::class, 'deleteclient'])->name('deleteclient');

    // Quotations CRUD
    Route::get('/quotations', [QuotationController::class, 'create'])->name('quotations');
    Route::post('/quotations', [QuotationController::class, 'addquotation'])->name('addquotation');
    Route::get('/quotationlist', [QuotationController::class, 'quotationlist'])->name('quotationlist');
    Route::delete('/quotations/{id}', [QuotationController::class, 'delete'])->name('quotations.delete');
    // Note: The two routes below have the same URL and should be reviewed, but I keep them as is.
    Route::get('/quotations/view/{id}', [QuotationController::class, 'view'])->name('view');
    Route::get('/quotations/view/{id}', [CompanyController::class, 'showQuotation'])->name('view'); 
    Route::get('/quotations/{id}/edit', [QuotationController::class, 'edit'])->name('editquotation');
    Route::put('/quotations/{id}', [QuotationController::class, 'update'])->name('updatequotation');
    Route::get('/quotations/{id}/copy', [QuotationController::class, 'copy'])->name('quotations.copy');
    // web.php
    Route::post('/quotations/generate-description', [QuotationController::class, 'generateDescription'])->name('quotations.generateDescription');

    // PDF routes
    Route::get('/quotations/download/{id}', [App\Http\Controllers\QuotationController::class, 'download'])->name('quotations.download');
    // send PDF to email
    Route::get('/quotations/send-email/{id}', [QuotationController::class, 'sendEmail'])->name('quotations.sendEmail');
    
    // Quotation status
    Route::prefix('quotations')->group(function () {
        Route::post('{id}/status', [QuotationStatusController::class, 'updateStatus'])->name('quotation.status.update');
        Route::get('{id}/status/history', [QuotationStatusController::class, 'history'])->name('quotation.status.history');
    });

    // Reports & Settings
    Route::get('/report', function () {
        return view('report');
    });
    Route::get('/report', [DashboardController::class, 'report'])->name('report');
    Route::get('/setting', function () {
        return view('setting');
    })->name('setting');

   
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'admin'])
        ->name('admin.dashboard');

    // Company crud operations
    Route::get('/settings/company', [CompanyController::class, 'index'])->name('company.settings');
    Route::post('/settings/company', [CompanyController::class, 'store'])->name('company.settings.store');
    Route::get('/settings/company', [CompanyController::class, 'edit'])->name('company.settings.edit');
    Route::post('/settings/company', [CompanyController::class, 'update'])->name('company.settings.store');
    Route::get('/setting', [CompanyController::class, 'settings'])->name('setting');
   
    // payment method
    Route::get('form', [PaymentController::class, 'showPaymentForm']);
    Route::post('/payment/stripe', [PaymentController::class, 'processStripePayment'])->name('payment.stripe');
    
    // EasyPaisa
    Route::post('/payment/easypaisa', [PaymentController::class, 'payWithEasyPaisa'])->name('payment.easypaisa');
    Route::any('/payment/easypaisa/callback', [PaymentController::class, 'easyPaisaCallback'])->name('payment.easypaisa.callback');

    // JazzCash
    Route::post('/payment/jazzcash', [PaymentController::class, 'payWithJazzCash'])->name('payment.jazzcash');
    Route::any('/payment/jazzcash/callback', [PaymentController::class, 'jazzCashCallback'])->name('payment.jazzcash.callback');

});


require __DIR__.'/auth.php';







