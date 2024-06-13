<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\GuestBlogController;
use App\Http\Controllers\MemberBlogController;
use App\Http\Controllers\MemberSewaSpotController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\GuestGaleriController;
use App\Http\Controllers\MemberGaleriController;
use App\Http\Controllers\VerificationController;
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

// Route::get('/', function () {
//     return view('welcome');
// })

// Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/', [GuestLandingPageController::class, 'index'])->name('landingpage.index');

// Routes Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Ubah Password 
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
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
    Route::get('/admin/sewaPemancingan/search', [AdminSewaPemancinganController::class, 'search'])->name('admin.sewaPemancingan.search');
    // Route::get('/admin/sewaPemancingan/checkAvailability', [AdminSewaPemancinganController::class, 'checkAvailability']);
    Route::get('/available-spots', [AdminSewaPemancinganController::class, 'getAvailableSpots'])->name('available-spots');
    Route::get('/available-sessions', [AdminSewaPemancinganController::class, 'getAvailableSessions'])->name('available-sessions');
    Route::post('/admin/sewaPemancingan/konfirmasi-pembayaran/{id}', [AdminSewaPemancinganController::class, 'konfirmasiPembayaran'])->name('admin.sewaPemancingan.konfirmasiPembayaran');
});


// Member Routes
Route::middleware(['auth', 'member'])->group(function () {
    // Landing Page Member
    Route::get('/member/landingPage', [MemberLandingPageController::class, 'index'])->name('member.landingpage.index');
    // Route::get('/landingPage', [MemberLandingPageController::class, 'index'])->name('landingpage.index');
    // Galeri Member
    Route::get('/member/galeriPemancingan', [MemberGaleriController::class, 'index'])->name('member.galeri.index');
    // Blog Member
    Route::get('/member/blogPemancingan', [MemberBlogController::class, 'index'])->name('member.blog.index');
    Route::get('/member/detailBlogPemancingan/{id}', [MemberBlogController::class, 'show'])->name('member.blog.detail-blog');
    // Sewa Spot Pemancingan
    // Route::get('/member/sewaPemancingan', [MemberSewaPemancinganController::class, 'index'])->name('member.sewa-pemancingan.index');
    Route::get('/member/sewaPemancingan/spots', [MemberSewaSpotController::class, 'index'])->name('member.spots.index');
    Route::post('/member/sewaPemancingan/spots/sewaSpot', [MemberSewaSpotController::class, 'store'])->name('member.spots.pesan-spot');
    Route::get('/member/sewaPemancingan/spots/riwayatSewa', [MemberSewaSpotController::class, 'riwayatSewa'])->name('member.spots.riwayat-sewa');
    Route::delete('/member/sewaPemancingan/spots/cancel/{sewaSpot}', [MemberSewaSpotController::class, 'cancelOrder'])->name('member.spots.cancel');
    Route::post('/member/sewaPemancingan/sposts/auto-cancel/{id}', [MemberSewaSpotController::class, 'autoCancel'])->name('member.spots.autoCancel');
    Route::get('/cek-ketersediaan', [MemberSewaSpotController::class, 'cekKetersediaan']);
    // Daftar Alat yang Disewakan Member
    Route::get('/member/daftarAlat', [MemberDaftarAlatController::class, 'index'])->name('member.daftar-alat.index');
    Route::post('/member/daftarAlat/sewaAlat', [MemberDaftarAlatController::class, 'store'])->name('member.sewa-alat');
    Route::get('/member/daftarAlat/sewaAlat/riwayatSewa', [MemberDaftarAlatController::class, 'riwayatSewaAlat'])->name('member.riwayat-sewa');
    Route::delete('/member/daftarAlat/sewaAlat/cancel/{sewaAlat}', [MemberDaftarAlatController::class, 'cancelOrder'])->name('member.sewa-alat.cancel');
    Route::post('/member/daftarAlat/sewaAlat/auto-cancel/{id}', [MemberDaftarAlatController::class, 'autoCancel'])->name('member.sewa-alat.autoCancel');

});


// Guest Routes
Route::prefix('guest')->name('guest.')->group(function () {
    // Landing Page Guest 
    Route::get('/landingPage', [GuestLandingPageController::class, 'index'])->name('landingpage.index');

    // Galeri Guest 
    Route::get('/galeriPemancingan', [GuestGaleriController::class, 'index'])->name('galeri.index');

    // Blog Guest 
    Route::get('/blogPemancingan', [GuestBlogController::class, 'index'])->name('blog.index');
    Route::get('/detailBlogPemancingan/{id}', [GuestBlogController::class, 'show'])->name('blog.detail-blog');

    // Daftar Alat yang Disewakan Guest 
    Route::get('/daftarAlat', [GuestDaftarAlatController::class, 'index'])->name('daftar-alat.index');
});



