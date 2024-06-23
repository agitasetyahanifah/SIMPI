<?php

namespace App\Http\Controllers;

use App\Models\AlatPancing;
use Illuminate\Http\Request;

class AdminAlatPancingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alatPancing = AlatPancing::orderBy('created_at', 'desc')->paginate(25);
        $lastItem = $alatPancing->lastItem();
        return view('admin.alatpancing.index', compact('alatPancing', 'lastItem'));
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
        ]);

        // Cari data alat pancing berdasarkan ID
        $alatPancing = AlatPancing::findOrFail($id);

        // Perbarui data alat pancing
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

        // Simpan perubahan data
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
