<?php

namespace App\Http\Controllers;

use App\Models\AlatPancing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAlatPancingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data alat pancing, diurutkan berdasarkan tanggal pembuatan secara menurun, dengan paginasi 25 item per halaman
        $alatPancing = AlatPancing::orderBy('created_at', 'desc')->paginate(25);
        // Mendapatkan item terakhir dari koleksi data yang dipaginasi
        $lastItem = $alatPancing->lastItem();
        // Mengembalikan view 'Admin.Alatpancing.index' dengan data 'alatPancing' dan 'lastItem'
        return view('Admin.Alatpancing.index', compact('alatPancing', 'lastItem'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
            'nama_alat' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'status' => 'required|string|in:available,not available',
            'spesifikasi' => 'nullable|string',
        ]);

        // Menyimpan foto ke dalam direktori public/images
        $fotoFileName = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->file('foto')->move(public_path('images'), $fotoFileName);

        // Membuat entri baru dalam tabel alat_pancing
        AlatPancing::create([
            'foto' => $fotoFileName, // Nama file foto
            'nama_alat' => $request->nama_alat,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'spesifikasi' => $request->spesifikasi,
            'user_id' => Auth::id(),
        ]);

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Fishing equipment added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'nama_alat' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'status' => 'required|in:available,not available',
            'spesifikasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048' // Validasi untuk foto hanya jika ada file yang diupload
        ]);
    
        // Cari data alat pancing berdasarkan ID
        $alatPancing = AlatPancing::findOrFail($id);
    
        // Simpan data saat ini untuk membandingkan perubahan
        $currentData = [
            'nama_alat' => $alatPancing->nama_alat,
            'harga' => $alatPancing->harga,
            'jumlah' => $alatPancing->jumlah,
            'status' => $alatPancing->status,
            'spesifikasi' => $alatPancing->spesifikasi,
            'foto' => $alatPancing->foto,
        ];
    
        // Perbarui data alat pancing berdasarkan input
        $alatPancing->nama_alat = $request->nama_alat;
        $alatPancing->harga = $request->harga;
        $alatPancing->jumlah = $request->jumlah;
        $alatPancing->status = $request->status;
        $alatPancing->spesifikasi = $request->spesifikasi;
    
        // Cek apakah ada file foto yang dikirim
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($alatPancing->foto) {
                unlink(public_path('images/' . $alatPancing->foto));
            }
    
            // Simpan foto baru
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/'), $namaFoto);
    
            $alatPancing->foto = $namaFoto;
        }
    
        // Periksa apakah ada perubahan pada data
        $isUpdated = $alatPancing->isDirty();
    
        // Jika tidak ada perubahan, kembalikan dengan pesan info
        if (!$isUpdated) {
            return redirect()->back()->with('info', 'No changes were made to the fishing equipment data.');
        }
    
        // Simpan perubahan data
        $alatPancing->user_id = Auth::id();
        $alatPancing->save();
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Fishing equipment data updated successfully');
    }   
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alatPancing = AlatPancing::findOrFail($id);
            
        // Hapus alat pancing dari database
        $alatPancing->delete();
            
        // Redirect kembali ke halaman daftar alat pancing dengan pesan sukses
        return redirect()->back()->with('success', 'Fishing equipment data has been successfully deleted.');
    }
}
