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
        $ikanMasuk = IkanMasuk::orderBy('tanggal', 'desc')->paginate(25);
        $lastItem1 = $ikanMasuk->lastItem();
        $ikanKeluar = IkanKeluar::orderBy('tanggal', 'desc')->paginate(25);
        $lastItem2 = $ikanKeluar->lastItem();

        return view('admin.pengelolaanIkan.index', compact('ikanMasuk', 'ikanKeluar', 'lastItem1', 'lastItem2'));
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
    public function storeIkanMasuk(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_ikan' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'catatan' => 'nullable|string',
        ]);
    
        // Simpan data ke database
        $ikanMasuk = new IkanMasuk();
        $ikanMasuk->tanggal = $validatedData['tanggal_transaksi'];
        $ikanMasuk->jenis_ikan = $validatedData['jenis_ikan'];
        $ikanMasuk->jumlah = $validatedData['jumlah'];
        $ikanMasuk->catatan = $validatedData['catatan'];
        $ikanMasuk->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Data ikan masuk berhasil ditambahkan.');
    }

    public function storeIkanKeluar(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_ikan' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'kondisi_ikan' => 'required',
            'catatan' => 'nullable|string',
        ]);
    
        // Simpan data ke database
        $ikanKeluar = new IkanKeluar();
        $ikanKeluar->tanggal = $validatedData['tanggal_transaksi'];
        $ikanKeluar->jenis_ikan = $validatedData['jenis_ikan'];
        $ikanKeluar->jumlah = $validatedData['jumlah'];
        $ikanKeluar->kondisi_ikan = $validatedData['kondisi_ikan'];
        $ikanKeluar->catatan = $validatedData['catatan'];
        $ikanKeluar->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Data ikan keluar berhasil ditambahkan.');
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
    public function updateIkanMasuk(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'edit_tanggal_transaksi' => 'required|date',
            'edit_jenis_ikan' => 'required',
            'edit_jumlah' => 'required|numeric|min:1',
            'edit_catatan' => 'nullable|string',
        ]);
    
        // Cari data ikan masuk berdasarkan ID
        $ikanMasuk = IkanMasuk::findOrFail($id);
    
        // Update data ikan masuk
        $ikanMasuk->tanggal = $validatedData['edit_tanggal_transaksi'];
        $ikanMasuk->jenis_ikan = $validatedData['edit_jenis_ikan'];
        $ikanMasuk->jumlah = $validatedData['edit_jumlah'];
        $ikanMasuk->catatan = $validatedData['edit_catatan'];
        $ikanMasuk->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Data ikan masuk berhasil diperbarui.');
    }

    public function updateIkanKeluar(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'edit_tanggal_transaksi' => 'required|date',
            'edit_jenis_ikan' => 'required',
            'edit_jumlah' => 'required|numeric|min:1',
            'edit_kondisi_ikan' => 'required',
            'edit_catatan' => 'nullable|string',
        ]);
    
        // Cari data ikan masuk berdasarkan ID
        $ikanKeluar = IkanKeluar::findOrFail($id);
    
        // Update data ikan masuk
        $ikanKeluar->tanggal = $validatedData['edit_tanggal_transaksi'];
        $ikanKeluar->jenis_ikan = $validatedData['edit_jenis_ikan'];
        $ikanKeluar->jumlah = $validatedData['edit_jumlah'];
        $ikanKeluar->catatan = $validatedData['edit_catatan'];
        $ikanKeluar->kondisi_ikan = $validatedData['edit_kondisi_ikan'];
        $ikanKeluar->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Data ikan keluar berhasil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteIkanMasuk($id)
    {
        // Cari data ikan masuk berdasarkan ID
        $ikanMasuk = IkanMasuk::findOrFail($id);
    
        // Hapus data ikan masuk
        $ikanMasuk->delete();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Data ikan masuk berhasil dihapus.');
    }

    public function deleteIkanKeluar($id)
    {
        // Cari data ikan masuk berdasarkan ID
        $ikanKeluar = IkanKeluar::findOrFail($id);
    
        // Hapus data ikan masuk
        $ikanKeluar->delete();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Data ikan keluar berhasil dihapus.');
    }
}
