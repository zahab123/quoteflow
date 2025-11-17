<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\QuotationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        // Clients crud operations
        Route::get('/client', function () {
            return view('client');
        });
        route::post('/client',[ClientController::class , 'addclient'])->name('addclient');
        route::get('/clientlist',[ClientController::class , 'clientlist']);
        route::get('/updateclient/{id}',[ClientController::class , 'updateclient'])->name('updateclient');
        route::post('/updateclient/{id}',[ClientController::class , 'postupdateclient'])->name('postupdateclient');
        route::get('/deleteclient/{id}',[ClientController::class , 'deleteclient'])->name('deleteclient');


        // Quotation crud operation
        Route::get('/quotations', function () {
            return view('quotations');
        });
        route::post('/quotations',[QuotationController::class , 'addquotation'])->name('addquotation');
        Route::get('/quotations', [QuotationController::class, 'create'])->name('quotations');
       
        Route::get('/quotationlist', function () {
            return view('quotationlist');
        });
        Route::get('/quotationlist', [QuotationController::class, 'quotationlist'])->name('quotationlist');




});

require __DIR__.'/auth.php';



route::get('admin/dashboard',[HomeController::class,'index'])->middleware(['auth', 'admin']);