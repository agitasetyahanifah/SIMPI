<?php

namespace App\Http\Controllers;

use App\Models\Visitors;
use App\Models\Galeri;
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

    public function uploadGambar(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $imageName = time().'.'.$request->image->extension();  
   
        $request->image->move(public_path('images'), $imageName);

        $image = new Galeri();
        $image->filename = $imageName;
        $image->save();

        return redirect()->back()->with('success', 'Gambar berhasil ditambahkan!');
    }
}
