<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotPemancingan;
use App\Models\SewaPemancingan;
use App\Models\Galeri;
use App\Models\Blog;
use App\Models\AlatPancing;
use Illuminate\Support\Carbon;

class GuestLandingPageController extends Controller
{
    public function index()
    {
        $images = Galeri::orderBy('created_at', 'desc')->paginate(6);
        $blogs = Blog::latest()->paginate(3);
        $alatPancing = AlatPancing::orderBy('created_at', 'desc')->paginate(6);
        $spotPemancingan = SpotPemancingan::latest()->first();
        
        // Panggil metode hitungTerakhirDiperbarui() untuk mendapatkan waktu terakhir diperbarui
        $terakhirDiperbaruiKetersediaan = $this->hitungTerakhirDiperbarui('ketersediaan');

        $waktuTerbaruSewaPemancingan = SewaPemancingan::latest('updated_at')->first();
        $waktuTerbaruSpotPemancingan = SpotPemancingan::latest('updated_at')->first();

        // Memeriksa apakah $waktuTerbaruSewaPemancingan tidak null
        if ($waktuTerbaruSewaPemancingan) {
            $carbonWaktuSewa = Carbon::parse($waktuTerbaruSewaPemancingan->updated_at);
        } else {
            // Tangani kasus jika $waktuTerbaruSewaPemancingan null
            $carbonWaktuSewa = null;
        }

        // Memeriksa apakah $waktuTerbaruSpotPemancingan tidak null
        if ($waktuTerbaruSpotPemancingan) {
            $carbonWaktuSpot = Carbon::parse($waktuTerbaruSpotPemancingan->updated_at);
        } else {
            // Tangani kasus jika $waktuTerbaruSpotPemancingan null
            $carbonWaktuSpot = null;
        }

        // Memeriksa apakah $waktuTerbaruSewaPemancingan tidak null
        $carbonWaktuSewa = $waktuTerbaruSewaPemancingan ? Carbon::parse($waktuTerbaruSewaPemancingan->updated_at) : null;

        // Memeriksa apakah $waktuTerbaruSpotPemancingan tidak null
        $carbonWaktuSpot = $waktuTerbaruSpotPemancingan ? Carbon::parse($waktuTerbaruSpotPemancingan->updated_at) : null;

        if ($carbonWaktuSewa && $carbonWaktuSpot) {
            // Jika kedua waktu tidak null, gunakan metode max() untuk mendapatkan waktu terbaru
            $waktuTerbaru = $carbonWaktuSewa->max($carbonWaktuSpot);
        } elseif ($carbonWaktuSewa) {
            // Jika hanya $carbonWaktuSewa yang tidak null
            $waktuTerbaru = $carbonWaktuSewa;
        } elseif ($carbonWaktuSpot) {
            // Jika hanya $carbonWaktuSpot yang tidak null
            $waktuTerbaru = $carbonWaktuSpot;
        } else {
            // Jika kedua waktu null
            $waktuTerbaru = null;
        }

        return view('guest.landingpage.index', compact(['spotPemancingan', 'terakhirDiperbaruiKetersediaan', 'waktuTerbaru', 'images', 'blogs', 'alatPancing']));
    }

    public function hitungTerakhirDiperbarui($jenis)
    {
        if ($jenis == 'ketersediaan') {
            // Ambil jumlah spot pancingan terakhir yang diupdate
            $jumlahSpotTerakhir = SpotPemancingan::latest()->value('jumlah');
            
            // Hitung banyaknya spot pancingan yang disewa pada hari ini
            $tanggalSewaHariIni = Carbon::today();
            $jumlahSpotDisewa = SewaPemancingan::whereDate('tanggal_sewa', $tanggalSewaHariIni)->sum('jumlah_sewa');

            // Hitung ketersediaan spot pancingan
            $ketersediaanSpotPancingan = $jumlahSpotTerakhir - $jumlahSpotDisewa;

            return $ketersediaanSpotPancingan;
        } elseif ($jenis == 'update') {
            // Ambil waktu terakhir update jumlah spot pemancingan
            $waktuTerakhirUpdate = SpotPemancingan::latest()->value('updated_at');

            return $waktuTerakhirUpdate;
        } else {
            return null;
        }
    }
}
