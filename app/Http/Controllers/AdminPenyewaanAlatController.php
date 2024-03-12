<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenyewaanAlat;
use App\Models\AlatPancing;

class AdminPenyewaanAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alatPancing = AlatPancing::all();
        $penyewaanAlat = PenyewaanAlat::latest()->get();
        return view('admin.penyewaanalat.index', compact('penyewaanAlat', 'alatPancing'));
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
        // Validasi input
        $request->validate([
            'nama_pelanggan' => 'required',
            'alat_pancing_id' => 'required|array',
            'alat_pancing_id.*' => 'exists:alat_pancing,id',
            'tanggal_pinjam' => 'required|date',
            'masa_pinjam' => 'required|numeric',
        ]);

        // Inisialisasi hargaTotal
        $hargaTotal = 0;

        // Iterasi melalui setiap id alat pancing yang dipilih
        foreach ($request->alat_pancing_id as $idAlat) {
            // Cari alat pancing berdasarkan id
            $alatPancing = AlatPancing::findOrFail($idAlat);

            // Tambahkan harga alat pancing ke harga total
            $hargaTotal += $alatPancing->harga;
        }

        // Simpan hargaTotal ke dalam input harga_alat untuk diakses oleh JavaScript
        $request->merge(['harga_alat' => $hargaTotal]);

        // Hitung biaya sewa
        $biayaSewa = $hargaTotal * $request->masa_pinjam;

        // Proses penyimpanan data penyewaan alat
        PenyewaanAlat::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alat_pancing_id' => $request->alat_pancing_id, // Ubah dari 'alat_pancing' menjadi 'alat_pancing_id'
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'masa_pinjam' => $request->masa_pinjam,
            'biaya_sewa' => $biayaSewa,
        ]);

        return redirect()->back()->with('success', 'Data Penyewaan alat berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
