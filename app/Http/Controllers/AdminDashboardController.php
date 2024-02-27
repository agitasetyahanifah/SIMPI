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
        $images = Galeri::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.index', compact(['visitors', 'images']));
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

    public function uploadGambar(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ], [
            'image.required' => 'Gambar harus dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 5 MB.',
        ]);

        // Check if the file is an image
        if ($request->file('image')->isValid()) {
            $imageName = time().'.'.$request->image->extension();  
    
            $request->image->move(public_path('images'), $imageName);

            $image = new Galeri();
            $image->filename = $imageName;
            $image->save();

            return redirect()->back()->with('success', 'Gambar berhasil ditambahkan!');
        } else {
            return redirect()->back()->withErrors(['image' => 'File yang diunggah bukanlah gambar yang valid.']);
        }
    }

    public function hapusGambar($id)
    {
        // Temukan gambar berdasarkan ID
        $image = Galeri::find($id);

        if (!$image) {
            // Jika gambar tidak ditemukan, kembalikan respons dengan status 404
            return response()->json(['message' => 'Gambar tidak ditemukan.'], 404);
        }

        // Hapus gambar dari sistem penyimpanan Anda
        // Misalnya, jika gambar disimpan di folder 'public/images', Anda dapat menggunakan fungsi unlink() untuk menghapusnya

        // Hapus entri gambar dari database
        $image->delete();

        // Kembalikan respons sukses
        return response()->json(['message' => 'Gambar berhasil dihapus.']);
    }
    
}
