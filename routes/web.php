<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('coins-markets', [HomeController::class, 'coinsMarkets'])->name('coins.markets');
    Route::get('history', [HistoryController::class, 'index'])->name('history');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('teams', [TeamController::class, 'index'])->name('teams');
    Route::get('level', [LevelController::class, 'index'])->name('level');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('investments', [InvestmentController::class, 'index'])->name('investments');
    Route::post('transaction/investment', [TransactionController::class, 'investment'])->name('transaction.investment');
    Route::post('transaction/claim-earning', [TransactionController::class, 'claimEarning'])->name('transaction.claimEarning');

    Route::post('transaction/deposit', [TransactionController::class, 'deposit'])->name('transaction.deposit');
    Route::post('transaction/withdraw', [TransactionController::class, 'withdraw'])->name('transaction.withdraw');
    Route::post('transaction/payment-confirmation', [TransactionController::class, 'paymentConfirmation'])->name('transaction.paymentConfirmation');
    Route::get('transaction/{uuid}', [TransactionController::class, 'view'])->name('transaction.view');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
