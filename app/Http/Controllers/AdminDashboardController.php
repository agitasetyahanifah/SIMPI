<?php

namespace App\Http\Controllers;

use App\Models\Visitors;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $visitors = Visitors::latest()->first();
        return view('admin.dashboard.index', compact('visitors'));
        // return view('admin.dashboard.index');
    }

    public function updatePengunjung(Request $request)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|integer'
        ]);

        // Buat objek Visitor dengan data yang diterima dari request
        $visitor = new Visitors();
        $visitor->jumlah = $request->jumlah;

        // Simpan objek Visitor ke database
        $visitor->save();

        // Redirect ke halaman lain atau tampilkan pesan sukses jika diperlukan
        return redirect()->back()->with('success', 'Jumlah pengunjung berhasil diupdate!');
    }
}
