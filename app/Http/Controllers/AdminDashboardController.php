<?php

namespace App\Http\Controllers;

use App\Models\SewaPemancingan;
use App\Models\Galeri;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $images = Galeri::orderBy('created_at', 'desc')->paginate(12);

        return view('admin.dashboard.index', compact(['images']));
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

    public function hapusGambar(Request $request)
    {
        // Validasi permintaan
        $request->validate([
            'image_id' => 'required|exists:galeri,id', // Pastikan ID gambar yang akan dihapus ada dalam tabel galeri
        ]);

        // Temukan gambar berdasarkan ID
        $image = Galeri::find($request->image_id);

        if (!$image) {
            // Jika gambar tidak ditemukan, kembalikan respons dengan status 404
            return response()->json(['error' => 'Gambar tidak ditemukan.'], 404);
        }

        // Hapus entri gambar dari database
        $image->delete();

        // Berikan respons dalam bentuk alert
        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }
    
}
