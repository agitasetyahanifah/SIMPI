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
        $images = Galeri::orderBy('created_at', 'desc')->paginate(3);
        $blogs = Blog::latest()->paginate(3);
        $alatPancing = AlatPancing::orderBy('created_at', 'desc')->paginate(6);

        return view('guest.landingpage.index', compact(['images', 'blogs', 'alatPancing']));
    }
}
