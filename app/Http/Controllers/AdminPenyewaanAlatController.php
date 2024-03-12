<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenyewaanAlat;
use App\Models\AlatPancing;
use Illuminate\Support\Facades\DB;

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
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alat_pancing_id' => 'required|array',
            'alat_pancing_id.*' => 'exists:alat_pancing,id',
            'tanggal_pinjam' => 'required|date',
            'masa_pinjam' => 'required|numeric|min:1',
        ]);
    
        // Inisialisasi harga total
        $hargaTotal = 0;

        // Iterasi melalui setiap ID alat pancing yang dipilih
        foreach ($request->alat_pancing_id as $idAlat) {
            // Cari alat pancing berdasarkan ID
            $alatPancing = AlatPancing::findOrFail($idAlat);

            // Tambahkan harga alat pancing ke harga total
            $hargaTotal += $alatPancing->harga;
        }

        // Hitung biaya sewa
        $biayaSewa = $hargaTotal * $request->masa_pinjam;

        // Mulai transaksi database
        DB::beginTransaction();

        // Simpan data penyewaan alat ke dalam database
        $penyewaanAlat = new PenyewaanAlat();
        $penyewaanAlat->nama_pelanggan = $validatedData['nama_pelanggan'];
        $penyewaanAlat->tgl_pinjam = $validatedData['tanggal_pinjam'];
        $penyewaanAlat->tgl_kembali = date('Y-m-d', strtotime($validatedData['tanggal_pinjam'] . ' + ' . $validatedData['masa_pinjam'] . ' days'));
        $penyewaanAlat->biaya_sewa = $biayaSewa;
        $penyewaanAlat->save();

        // Lampirkan alat pancing yang disewa ke penyewaan alat
        $penyewaanAlat->alatPancing()->attach($validatedData['alat_pancing_id']);

        // Commit transaksi jika tidak ada masalah
        DB::commit();

        // Redirect kembali dengan pesan sukses
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
