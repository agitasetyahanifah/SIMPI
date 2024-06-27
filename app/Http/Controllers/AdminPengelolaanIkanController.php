<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\IkanMasuk;
use App\Models\IkanKeluar;
use App\Models\JenisIkan;

class AdminPengelolaanIkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data ikan masuk, diurutkan berdasarkan tanggal dan tanggal update secara menurun, dengan paginasi 25 item per halaman
        $ikanMasuk = IkanMasuk::orderBy('tanggal', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
        // Mendapatkan item terakhir dari koleksi data ikan masuk yang dipaginasi
        $lastItem1 = $ikanMasuk->lastItem();
        // Mengambil data ikan keluar, diurutkan berdasarkan tanggal dan tanggal update secara menurun, dengan paginasi 25 item per halaman
        $ikanKeluar = IkanKeluar::orderBy('tanggal', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
        $lastItem2 = $ikanKeluar->lastItem();
        // Mengambil data jenis ikan, diurutkan berdasarkan tanggal pembuatan secara menurun, dengan paginasi 5 item per halaman
        $jenisIkan = JenisIkan::orderByDesc('created_at')->paginate(5);
        $lastItem3 = $jenisIkan->lastItem();
        // Mengambil semua data jenis ikan
        $jenisIkanOpt = JenisIkan::all();

        // Mengembalikan view 'admin.pengelolaanIkan.index' dengan data 'ikanMasuk', 'ikanKeluar', 'lastItem1', 'lastItem2', 'jenisIkan', 'lastItem3', dan 'jenisIkanOpt'
        return view('admin.pengelolaanIkan.index', compact('ikanMasuk', 'ikanKeluar', 'lastItem1', 'lastItem2','jenisIkan', 'lastItem3','jenisIkanOpt'));
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
            'tanggal_ikan_masuk' => 'required|date',
            'jenis_ikan' => 'required|exists:jenis_ikan,id',
            'jumlah' => 'required|numeric|min:1',
            'catatan' => 'nullable|string',
        ]);
    
        // Simpan data ke database
        $ikanMasuk = new IkanMasuk();
        $ikanMasuk->tanggal = $validatedData['tanggal_ikan_masuk'];
        $ikanMasuk->jenis_ikan_id = $validatedData['jenis_ikan'];
        $ikanMasuk->jumlah = $validatedData['jumlah'];
        $ikanMasuk->catatan = $validatedData['catatan'];
        $ikanMasuk->user_id = Auth::id();
        $ikanMasuk->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Incoming fish data added successfully.');
    }

    public function storeIkanKeluar(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'tanggal_ikan_keluar' => 'required|date',
            'jenis_ikan' => 'required|exists:jenis_ikan,id',
            'jumlah' => 'required|numeric|min:1',
            'kondisi_ikan' => 'required',
            'catatan' => 'nullable|string',
        ]);
    
        // Simpan data ke database
        $ikanKeluar = new IkanKeluar();
        $ikanKeluar->tanggal = $validatedData['tanggal_ikan_keluar'];
        $ikanKeluar->jenis_ikan_id = $validatedData['jenis_ikan'];
        $ikanKeluar->jumlah = $validatedData['jumlah'];
        $ikanKeluar->kondisi_ikan = $validatedData['kondisi_ikan'];
        $ikanKeluar->catatan = $validatedData['catatan'];
        $ikanKeluar->user_id = Auth::id();
        $ikanKeluar->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Outcoming fish data has been successfully added.');
    }

    public function storeJenisIkan(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'jenis_ikan' => 'required',
        ]);
    
        // Simpan data ke database
        $jenisIkan = new JenisIkan();
        $jenisIkan->jenis_ikan = $validatedData['jenis_ikan'];
        $jenisIkan->user_id = Auth::id();
        $jenisIkan->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Fish type data successfully added.');
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
            'edit_tanggal_ikan_masuk' => 'required|date',
            'edit_jenis_ikan' => 'required|exists:jenis_ikan,id',
            'edit_jumlah' => 'required|numeric|min:1',
            'edit_catatan' => 'nullable|string',
        ]);
    
        // Cari data ikan masuk berdasarkan ID
        $ikanMasuk = IkanMasuk::findOrFail($id);
    
        // Update data ikan masuk
        $ikanMasuk->tanggal = $validatedData['edit_tanggal_ikan_masuk'];
        $ikanMasuk->jenis_ikan_id = $validatedData['edit_jenis_ikan'];
        $ikanMasuk->jumlah = $validatedData['edit_jumlah'];
        $ikanMasuk->catatan = $validatedData['edit_catatan'];
        $ikanMasuk->user_id = Auth::id();
        $ikanMasuk->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Incoming fish data updated successfully.');
    }

    public function updateIkanKeluar(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'edit_tanggal_ikan_keluar' => 'required|date',
            'edit_jenis_ikan' => 'required|exists:jenis_ikan,id',
            'edit_jumlah' => 'required|numeric|min:1',
            'edit_kondisi_ikan' => 'required',
            'edit_catatan' => 'nullable|string',
        ]);
    
        // Cari data ikan masuk berdasarkan ID
        $ikanKeluar = IkanKeluar::findOrFail($id);
    
        // Update data ikan masuk
        $ikanKeluar->tanggal = $validatedData['edit_tanggal_ikan_keluar'];
        $ikanKeluar->jenis_ikan_id = $validatedData['edit_jenis_ikan'];
        $ikanKeluar->jumlah = $validatedData['edit_jumlah'];
        $ikanKeluar->catatan = $validatedData['edit_catatan'];
        $ikanKeluar->kondisi_ikan = $validatedData['edit_kondisi_ikan'];
        $ikanKeluar->user_id = Auth::id();
        $ikanKeluar->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Outcoming fish data has been updated successfully.');
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
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Incoming fish data has been successfully deleted.');
    }

    public function deleteIkanKeluar($id)
    {
        // Cari data ikan masuk berdasarkan ID
        $ikanKeluar = IkanKeluar::findOrFail($id);
    
        // Hapus data ikan masuk
        $ikanKeluar->delete();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Outcoming fish data has been successfully deleted.');
    }

    public function deleteJenisIkan($id)
    {
        // Nonaktifkan foreign key constraint sementara
        Schema::disableForeignKeyConstraints();
    
        // Cari data ikan masuk berdasarkan ID
        $jenisIkan = JenisIkan::findOrFail($id);
    
        // Hapus data ikan masuk
        $jenisIkan->delete();
    
        // Aktifkan kembali foreign key constraint
        Schema::enableForeignKeyConstraints();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('admin.pengelolaanIkan.index')->with('success', 'Fish type data has been successfully deleted.');
    }
    
}
