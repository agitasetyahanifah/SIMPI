<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class AdminKeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::all();
        return view('admin.keuangan.index', compact('keuangans'));
    }
}
