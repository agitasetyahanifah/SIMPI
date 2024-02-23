<?php

namespace App\Http\Controllers;

use App\Models\ManajemenKeuangan;
use Illuminate\Http\Request;

class ManajemenKeuanganController extends Controller
{
    public function index()
    {
        $manajemenkeuangan = ManajemenKeuangan::all();
        return view('Admin.ManajemenKeuangan.ManajemenKeuangan', ['manajemenkeuangan' => $manajemenkeuangan]);
    }
}
