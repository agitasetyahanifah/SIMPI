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
        // Mengambil 3 gambar terbaru dari Galeri, diurutkan berdasarkan tanggal pembuatan terbaru
        $images = Galeri::orderBy('created_at', 'desc')->paginate(3);
        // Mengambil 3 blog terbaru dari Blog, diurutkan berdasarkan tanggal pembuatan terbaru
        $blogs = Blog::latest()->paginate(3);
        // Mengambil 6 alat pancing terbaru dari AlatPancing, diurutkan berdasarkan tanggal pembuatan terbaru
        $alatPancing = AlatPancing::orderBy('created_at', 'desc')->paginate(6);

        // Mengembalikan view 'guest.landingpage.index' dengan data 'images', 'blogs', dan 'alatPancing'
        return view('Guest.LandingPage.index', compact(['images', 'blogs', 'alatPancing']));
    }
}
