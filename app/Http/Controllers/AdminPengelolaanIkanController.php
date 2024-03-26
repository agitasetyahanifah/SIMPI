<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IkanMasuk;
use App\Models\IkanKeluar;

class AdminPengelolaanIkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ikanMasuk = IkanMasuk::all();
        $ikanKeluar = IkanKeluar::all();

        return view('admin.ikan.index', compact('ikanMasuk', 'ikanKeluar'));
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
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_ikan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        IkanMasuk::create($request->all());

        return redirect()->route('ikan.index')->with('success', 'Data ikan masuk berhasil ditambahkan.');
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
    public function update(Request $request, IkanMasuk $ikanMasuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_ikan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $ikanMasuk->update($request->all());

        return redirect()->route('ikan.index')->with('success', 'Data ikan masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IkanMasuk $ikanMasuk)
    {
        $ikanMasuk->delete();

        return redirect()->route('ikan.index')->with('success', 'Data ikan masuk berhasil dihapus.');
    }
}
