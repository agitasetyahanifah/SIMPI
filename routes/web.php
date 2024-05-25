<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\GuestBlogController;
use App\Http\Controllers\MemberBlogController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\GuestGaleriController;
use App\Http\Controllers\MemberGaleriController;
use App\Http\Controllers\AdminKeuanganController;
use App\Http\Controllers\AdminSewaAlatController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\GuestDaftarAlatController;
use App\Http\Controllers\AdminAlatPancingController;
use App\Http\Controllers\GuestLandingPageController;
use App\Http\Controllers\MemberDaftarAlatController;
use App\Http\Controllers\MemberLandingPageController;
use App\Http\Controllers\AdminPengelolaanIkanController;
use App\Http\Controllers\AdminSewaPemancinganController;
use App\Http\Controllers\MemberSewaPemancinganController;

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
// Rute dashboard admin 
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
Route::post('/admin/dashboard/updateSpotPemancingan', [AdminDashboardController::class, 'updateSpotPemancingan'])->name('admin.dashboard.updateSpotPemancingan');
Route::get('/admin/dashboard/hitungKetersediaanSpotPancingan', [AdminDashboardController::class, 'hitungKetersediaanSpotPancingan'])->name('admin.dashboard.hitungKetersediaanSpotPancingan');
Route::post('/admin/dashboard/uploadGambar', [AdminDashboardController::class, 'uploadGambar'])->name('admin.dashboard.uploadGambar');
Route::delete('/admin/dashboard/{id}', [AdminDashboardController::class, 'hapusGambar'])->name('admin.dashboard.hapusGambar');
// Rute keuangan admin 
Route::get('/admin/keuangan', [AdminKeuanganController::class, 'index'])->name('admin.keuangan.index');
Route::post('/admin/keuangan/store', [AdminKeuanganController::class, 'store'])->name('admin.keuangan.store');
Route::delete('/admin/keuangan/{id}', [AdminKeuanganController::class, 'destroy'])->name('admin.keuangan.destroy');
Route::get('/admin/keuangan/edit/{id}', [AdminKeuanganController::class, 'edit'])->name('admin.keuangan.edit');
Route::put('/admin/keuangan/update/{id}', [AdminKeuanganController::class, 'update'])->name('admin.keuangan.update');
// Rute alat pancing 
Route::resource('/admin/alatPancing', AdminAlatPancingController::class);
// Rute sewa alat 
Route::resource('/admin/sewaAlat', AdminSewaAlatController::class);
Route::put('/admin/sewaAlat/{id}', [AdminSewaAlatController::class, 'update'])->name('admin.sewaAlat.update');
Route::post('/admin/sewaAlat/konfirmasi-pembayaran/{id}', [AdminSewaAlatController::class, 'konfirmasiPembayaran'])->name('admin.sewaAlat.konfirmasiPembayaran');
// Rute untuk menampilkan halaman utama pengelolaan ikan
Route::get('/admin/pengelolaanIkan', [AdminPengelolaanIkanController::class, 'index'])->name('admin.pengelolaanIkan.index');
// Rute untuk jenis ikan
Route::post('/admin/pengelolaanIkan/tambahIkan', [AdminPengelolaanIkanController::class, 'storeJenisIkan'])->name('admin.pengelolaan_ikan.jenis_ikan.store');
Route::delete('/admin/pengelolaanIkan/hapusIkan/{id}/delete', [AdminPengelolaanIkanController::class, 'deleteJenisIkan'])->name('admin.pengelolaan_ikan.jenis_ikan.delete');
// Rute CRUD untuk ikan masuk
Route::post('/admin/pengelolaanIkan/ikan-masuk/store', [AdminPengelolaanIkanController::class, 'storeIkanMasuk'])->name('admin.pengelolaan_ikan.ikan_masuk.store');
Route::put('/admin/pengelolaanIkan/ikan-masuk/{id}/update', [AdminPengelolaanIkanController::class, 'updateIkanMasuk'])->name('admin.pengelolaan_ikan.ikan_masuk.update');
Route::delete('/admin/pengelolaanIkan/ikan-masuk/{id}/delete', [AdminPengelolaanIkanController::class, 'deleteIkanMasuk'])->name('admin.pengelolaan_ikan.ikan_masuk.delete');
// Rute CRUD untuk ikan keluar
Route::post('/admin/pengelolaanIkan/ikan-keluar/store', [AdminPengelolaanIkanController::class, 'storeIkanKeluar'])->name('admin.pengelolaan_ikan.ikan_keluar.store');
Route::put('/admin/pengelolaanIkan/ikan-keluar/{id}/update', [AdminPengelolaanIkanController::class, 'updateIkanKeluar'])->name('admin.pengelolaan_ikan.ikan_keluar.update');
Route::delete('/admin/pengelolaanIkan/ikan-keluar/{id}/delete', [AdminPengelolaanIkanController::class, 'deleteIkanKeluar'])->name('admin.pengelolaan_ikan.ikan_keluar.delete');
// Rute blog
Route::get('/admin/blog/checkSlug', [AdminBlogController::class, 'checkSlug'])->name('admin.blog.checkSlug');
Route::resource('/admin/blog', AdminBlogController::class);
// Rute untuk ketegori blog
Route::post('/admin/blog/tambahKategori', [AdminBlogController::class, 'storeKategori'])->name('admin.blog.tambah_kategori');
Route::delete('/admin/blog/hapusKategori/{id}', [AdminBlogController::class, 'deleteKategori'])->name('admin.blog.delete_kategori');
// Rute Manajemen Member
Route::resource('/admin/members', AdminMemberController::class);
// Rute Booking Tempat Pemancingan
Route::resource('/admin/sewaPemancingan', AdminSewaPemancinganController::class);
Route::post('/admin/sewaPemancingan/konfirmasi-pembayaran/{id}', [AdminSewaPemancinganController::class, 'konfirmasiPembayaran'])->name('admin.sewaPemancingan.konfirmasiPembayaran');


// Guest 
// Landing Page Guest 
Route::get('/guest/landingPage', [GuestLandingPageController::class, 'index'])->name('guest.landingpage.index');
// Galeri Guest 
Route::get('/guest/galeriPemancingan', [GuestGaleriController::class, 'index'])->name('guest.galeri.index');
// Blog Guest 
Route::get('/guest/blogPemancingan', [GuestBlogController::class, 'index'])->name('guest.blog.index');
Route::get('/guest/detailBlogPemancingan/{id}', [GuestBlogController::class, 'show'])->name('guest.blog.detail-blog');
// Daftar Alat yang Disewakan Guest 
Route::get('/guest/daftarAlat', [GuestDaftarAlatController::class, 'index'])->name('guest.daftar-alat.index');


// Member
// Landing Page Member
Route::get('/member/landingPage', [MemberLandingPageController::class, 'index'])->name('member.landingpage.index');
// Galeri Member
Route::get('/member/galeriPemancingan', [MemberGaleriController::class, 'index'])->name('member.galeri.index');
// Blog Member
Route::get('/member/blogPemancingan', [MemberBlogController::class, 'index'])->name('member.blog.index');
Route::get('/member/detailBlogPemancingan/{id}', [MemberBlogController::class, 'show'])->name('member.blog.detail-blog');
// Sewa Spot Pemancingan
Route::get('/member/sewaPemancingan', [MemberSewaPemancinganController::class, 'index'])->name('member.sewa-pemancingan.index');
// Daftar Alat yang Disewakan Member
Route::get('/member/daftarAlat', [MemberDaftarAlatController::class, 'index'])->name('member.daftar-alat.index');