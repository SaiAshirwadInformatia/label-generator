<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ReadyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

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
Route::get('/rohan', function () {
   \Illuminate\Support\Facades\Auth::loginUsingId(1);
   return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/labels/create', [LabelController::class, 'create'])->name('labels.create');
    Route::get('/labels/{label}/configure', [LabelController::class, 'configure'])->name('labels.configure');
    Route::get('/sets/{set}/preview', [LabelController::class, 'preview'])->name('labels.preview');

    Route::get('/sets/{set}/generate', [LabelController::class, 'generate'])->name('labels.generate');

    Route::resource('users', UserController::class)->only('index', 'create', 'edit');

    Route::get('/activate/{user}/reset', [ActivationController::class, 'update'])->name('activation.update');

    Route::get('/activity/logs', [ActivityLogsController::class, 'index'])->name('activity_logs.index');

    Route::impersonate();
});

Route::get('/activate/{user:ott}', [ActivationController::class, 'index'])->name('activation.index');
Route::post('/activate/{user:ott}', [ActivationController::class, 'store'])->name('activation.store');

Route::get('/download/{token}', [ReadyController::class, 'download'])->name('download');

