<?php

use Spatie\Health\Http\Controllers\HealthCheckResultsController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ReadyController;
use App\Http\Livewire\LabelConfigure;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/labels/create', [LabelController::class, 'create'])->name('labels.create');
    Route::get('/labels/{label}/configure', [LabelController::class, 'configure'])->name('labels.configure');
    Route::get('/sets/{set}/preview', [LabelController::class, 'preview'])->name('labels.preview');
});

Route::get('/download/{token}', [ReadyController::class, 'download'])->name('download');



Route::get('health', HealthCheckResultsController::class);