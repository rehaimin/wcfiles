<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('upload');
})->name('upload');

Route::post('store', [FileController::class, 'store'])->name('store');
Route::get('download/{token}', [FileController::class, 'download'])->name('download');
Route::get('delete/{token}', [FileController::class, 'delete'])->name('delete');
Route::get('edit/{token}', [FileController::class, 'edit'])->name('edit');
Route::post('update/{token}', [FileController::class, 'update'])->name('update');
Route::get('/files', [FileController::class, 'index'])->name('index');
