<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityRestoreController;
use App\Http\Controllers\ActivityTrashController;
use App\Http\Controllers\PageController;
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

Route::get('/', [PageController::class, 'index'])->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes for Activity
    Route::resource('activity', ActivityController::class);
    Route::get('/activity-trash', [ActivityController::class, 'trash'])->name('activity.trash');
    Route::delete('/activity-destroy-forever/{activity_id}', [ActivityController::class, 'destroyForever'])->name('activity.destroy_forever');
    Route::post('/activity-restore/{activity_id}', [ActivityController::class, 'restore'])->name('activity.restore');
});
