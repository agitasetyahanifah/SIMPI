<?php

namespace App\Http\Controllers;

use App\Models\SewaPemancingan;
use App\Models\Galeri;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Mengambil data gambar dari model Galeri, diurutkan berdasarkan tanggal pembuatan secara menurun, dan dibatasi 12 per halaman
        $images = Galeri::orderBy('created_at', 'desc')->paginate(12);

        // Mengembalikan view 'admin.dashboard.index' dengan data 'images'
        return view('Admin.Dashboard.index', compact(['images']));
    }

    public function uploadGambar(Request $request)
    {
        // Validasi input 'image' harus berupa gambar dengan format jpeg, png, jpg, atau gif, dan ukuran maksimal 5 MB
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ], [
            'image.required' => 'Image must be selected.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image format must be jpeg, png, jpg, or gif.',
            'image.max' => 'Image size should not exceed 5 MB.',
        ]);

        // Jika file gambar valid
        if ($request->file('image')->isValid()) {
            // Generate nama file unik dengan timestamp dan ekstensi asli
            $imageName = time().'.'.$request->image->extension();  
    
            // Pindahkan file gambar ke direktori 'public/images'
            $request->image->move(public_path('images'), $imageName);

            // Simpan informasi gambar ke database
            $image = new Galeri();
            $image->filename = $imageName;
            $image->user_id = Auth::id();
            $image->save();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Image added successfully!');
        } else {
            // Redirect kembali dengan pesan error jika file tidak valid
            return redirect()->back()->withErrors(['image' => 'The uploaded file is not a valid image.']);
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
            return response()->json(['error' => 'Image not found.'], 404);
        }

        // Hapus entri gambar dari database
        $image->delete();

        // Berikan respons dalam bentuk alert
        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
    
}
