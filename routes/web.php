<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentMethodController;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Route::get('/dashboard', [TransactionController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/bugsnag-test', function () {
    throw new \Exception('what a terrible bug!');
});

Route::middleware('auth')->group(function () {
    Route::prefix('transaction')->name('transaction.')->group(function () {

        Route::get('/', [TransactionController::class, 'index'])->name('index');

        Route::get('/show{id}', [TransactionController::class, 'show'])->name('show');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::get('/edit{id}', [TransactionController::class, 'edit'])->name('edit');
        Route::get('/destroy{id}', [TransactionController::class, 'destroy'])->name('destroy');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::post('/update{id}', [TransactionController::class, 'update'])->name('update');
        Route::get('/pending', [TransactionController::class, 'pending'])->name('pending');
        Route::put('/{id}/update-status', [TransactionController::class, 'updateStatus'])->name('updateStatus');
    });




    Route::prefix('paymob')->name('paymob.')->group(function () {
        Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('/show{id}', [PaymentMethodController::class, 'show'])->name('show');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('create');
        Route::get('/edit{id}', [PaymentMethodController::class, 'edit'])->name('edit');
        Route::get('/destroy{id}', [PaymentMethodController::class, 'destroy'])->name('destroy');
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('store');
        Route::post('/update{id}', [PaymentMethodController::class, 'update'])->name('update');
        Route::post('/process', [PaymentMethodController::class, 'process'])->name('process');
    });




    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
        Route::post('/change_image{id}', [ProfileController::class, 'change_image'])->name('change_image');
        Route::post('/delete_image{id}', [ProfileController::class, 'delete_image'])->name('delete_image');
        Route::GET('/settings', [ProfileController::class, 'settings'])->name('settings');
    });
});
require __DIR__ . '/auth.php';
