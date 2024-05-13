<?php

namespace App\Http\Controllers;

use App\Models\SpotPemancingan;
use App\Models\SewaPemancingan;
use App\Models\Galeri;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $spotPemancingan = SpotPemancingan::latest()->first();
        $images = Galeri::orderBy('created_at', 'desc')->paginate(6);
        
        // Panggil metode hitungTerakhirDiperbarui() untuk mendapatkan waktu terakhir diperbarui
        $terakhirDiperbaruiKetersediaan = $this->hitungTerakhirDiperbarui('ketersediaan');

        $waktuTerbaruSewaPemancingan = SewaPemancingan::latest('updated_at')->first();
        $waktuTerbaruSpotPemancingan = SpotPemancingan::latest('updated_at')->first();

        // Buat objek Carbon untuk kedua waktu yang ingin Anda bandingkan
        $carbonWaktuSewa = Carbon::parse($waktuTerbaruSewaPemancingan->updated_at);
        $carbonWaktuSpot = Carbon::parse($waktuTerbaruSpotPemancingan->updated_at);

        // Gunakan metode max() pada objek Carbon untuk mendapatkan waktu terbaru
        $waktuTerbaru = $carbonWaktuSewa->max($carbonWaktuSpot);

        return view('admin.dashboard.index', compact(['spotPemancingan', 'images', 'terakhirDiperbaruiKetersediaan', 'waktuTerbaru']));
    }

    public function hitungTerakhirDiperbarui($jenis)
    {
        if ($jenis == 'ketersediaan') {
            // Ambil jumlah spot pancingan terakhir yang diupdate
            $jumlahSpotTerakhir = SpotPemancingan::latest()->value('jumlah');
            
            // Hitung banyaknya spot pancingan yang disewa pada hari ini
            $tanggalSewaHariIni = Carbon::today();
            $jumlahSpotDisewa = SewaPemancingan::whereDate('tanggal_sewa', $tanggalSewaHariIni)->sum('jumlah_sewa');

            // Hitung ketersediaan spot pancingan
            $ketersediaanSpotPancingan = $jumlahSpotTerakhir - $jumlahSpotDisewa;

            return $ketersediaanSpotPancingan;
        } elseif ($jenis == 'update') {
            // Ambil waktu terakhir update jumlah spot pemancingan
            $waktuTerakhirUpdate = SpotPemancingan::latest()->value('updated_at');

            return $waktuTerakhirUpdate;
        } else {
            return null;
        }
    }

    public function updateSpotPemancingan(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'updateSpotPemancingan' => 'required|integer|min:0',
        ]);

        // Buat objek spot dengan data yang diterima dari request
        $spotPemancingan = new SpotPemancingan();
        $spotPemancingan->jumlah = $validatedData['updateSpotPemancingan'];

        // Simpan objek spot ke database
        $spotPemancingan->save();

        // Redirect ke halaman lain atau tampilkan pesan sukses jika diperlukan
        return redirect()->back()->with('success', 'Jumlah spot pemancingan berhasil diupdate!');
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
