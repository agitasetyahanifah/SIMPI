<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminKeuanganController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
});

// Admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
Route::post('/admin/dashboard/updatePengunjung', [AdminDashboardController::class, 'updatePengunjung'])->name('admin.dashboard.updatePengunjung');
Route::post('/admin/dashboard/uploadGambar', [AdminDashboardController::class, 'uploadGambar'])->name('admin.dashboard.uploadGambar');
Route::delete('/admin/dashboard/{id}', [AdminDashboardController::class, 'hapusGambar'])->name('admin.dashboard.hapusGambar');
Route::get('/admin/keuangan/', [AdminKeuanganController::class, 'index'])->name('admin.keuangan.index');
Route::post('admin/keuangan/store', [AdminKeuanganController::class, 'store'])->name('admin.keuangan.store');
Route::delete('/admin/keuangan/{id}', [AdminKeuanganController::class, 'destroy'])->name('admin.keuangan.destroy');
