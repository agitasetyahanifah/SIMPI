<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestLandingPageController extends Controller
{
    public function index()
    {
        return view('guest.landingpage.index');
    }
}
