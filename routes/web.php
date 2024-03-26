<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminKeuanganController;
use App\Http\Controllers\AdminAlatPancingController;
use App\Http\Controllers\AdminPenyewaanAlatController;
use App\Http\Controllers\AdminPengelolaanIkanController;
use Database\Seeders\AdminDashboardSeeder;
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
    return view('welcome');
});

// Admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
Route::post('/admin/dashboard/updatePengunjung', [AdminDashboardController::class, 'updatePengunjung'])->name('admin.dashboard.updatePengunjung');
Route::post('/admin/dashboard/uploadGambar', [AdminDashboardController::class, 'uploadGambar'])->name('admin.dashboard.uploadGambar');
Route::delete('/admin/dashboard/{id}', [AdminDashboardController::class, 'hapusGambar'])->name('admin.dashboard.hapusGambar');
Route::get('/admin/keuangan', [AdminKeuanganController::class, 'index'])->name('admin.keuangan.index');
Route::post('/admin/keuangan/store', [AdminKeuanganController::class, 'store'])->name('admin.keuangan.store');
Route::delete('/admin/keuangan/{id}', [AdminKeuanganController::class, 'destroy'])->name('admin.keuangan.destroy');
Route::get('/admin/keuangan/edit/{id}', [AdminKeuanganController::class, 'edit'])->name('admin.keuangan.edit');
Route::put('/admin/keuangan/update/{id}', [AdminKeuanganController::class, 'update'])->name('admin.keuangan.update');
Route::resource('/admin/alatPancing', AdminAlatPancingController::class);
Route::resource('/admin/penyewaanAlat', AdminPenyewaanAlatController::class);




Route::get('admin/pengelolaanIkan', [AdminPengelolaanIkanController::class, 'index'])->name('admin.ikan.index');
Route::get('/pengelolaanIkan/create', [AdminPengelolaanIkanController::class, 'create'])->name('admin.ikan.create');
Route::post('/pengelolaanIkan', [AdminPengelolaanIkanController::class, 'store'])->name('admin.ikan.store');
Route::get('/pengelolaanIkan/{ikanMasuk}/edit', [AdminPengelolaanIkanController::class, 'edit'])->name('admin.ikan.edit');
Route::put('/pengelolaanIkan/{ikanMasuk}', [AdminPengelolaanIkanController::class, 'update'])->name('admin.ikan.update');
Route::delete('/pengelolaanIkan/{ikanMasuk}', [AdminPengelolaanIkanController::class, 'destroy'])->name('admin.ikan.destroy');
