<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminKeuanganController extends Controller
{
    public function index()
    {
        return view('admin.keuangan.index');
    }
}
