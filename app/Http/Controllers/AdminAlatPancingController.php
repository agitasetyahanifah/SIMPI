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
        $alatPancing = AlatPancing::latest()->get();
        return view('admin.alatpancing.index', compact('alatPancing'));
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
        $fotoFileName = $request->file('foto')->getClientOriginalName(); // Mendapatkan nama file
        $request->file('foto')->move(public_path('images'), $fotoFileName);

        // Membuat entri baru dalam tabel alat_pancing
        AlatPancing::create([
            'foto' => $fotoFileName, // Nama file foto
            'nama_alat' => $request->nama_alat, // Nama alat
            'harga' => $request->harga, // Harga
            'jumlah' => $request->jumlah, // Jumlah
            'status' => $request->status, // Status
            'spesifikasi' => $request->spesifikasi, // Spesifikasi (opsional)
        ]);

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Alat pancing berhasil ditambahkan.');
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
