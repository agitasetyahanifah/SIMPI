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
    
        // Simpan data saat ini untuk membandingkan perubahan
        $currentData = [
            'tanggal' => $ikanMasuk->tanggal,
            'jenis_ikan_id' => $ikanMasuk->jenis_ikan_id,
            'jumlah' => $ikanMasuk->jumlah,
            'catatan' => $ikanMasuk->catatan,
        ];
    
        // Update data ikan masuk hanya jika ada perubahan
        $ikanMasuk->fill([
            'tanggal' => $validatedData['edit_tanggal_ikan_masuk'],
            'jenis_ikan_id' => $validatedData['edit_jenis_ikan'],
            'jumlah' => $validatedData['edit_jumlah'],
            'catatan' => $validatedData['edit_catatan'],
            'user_id' => Auth::id(),
        ]);
    
        // Periksa apakah ada perubahan pada data
        $isUpdated = $ikanMasuk->isDirty();
    
        // Jika tidak ada perubahan, kembalikan dengan pesan info
        if (!$isUpdated) {
            return redirect()->route('admin.pengelolaanIkan.index')->with('info', 'No changes were made to the incoming fish data.');
        }
    
        // Simpan perubahan data ikan masuk
        $ikanMasuk->save();
    
        // Redirect dengan pesan sukses
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
    
        // Cari data ikan keluar berdasarkan ID
        $ikanKeluar = IkanKeluar::findOrFail($id);
    
        // Simpan data saat ini untuk membandingkan perubahan
        $currentData = [
            'tanggal' => $ikanKeluar->tanggal,
            'jenis_ikan_id' => $ikanKeluar->jenis_ikan_id,
            'jumlah' => $ikanKeluar->jumlah,
            'catatan' => $ikanKeluar->catatan,
            'kondisi_ikan' => $ikanKeluar->kondisi_ikan,
        ];
    
        // Update data ikan keluar hanya jika ada perubahan
        $ikanKeluar->fill([
            'tanggal' => $validatedData['edit_tanggal_ikan_keluar'],
            'jenis_ikan_id' => $validatedData['edit_jenis_ikan'],
            'jumlah' => $validatedData['edit_jumlah'],
            'catatan' => $validatedData['edit_catatan'],
            'kondisi_ikan' => $validatedData['edit_kondisi_ikan'],
            'user_id' => Auth::id(),
        ]);
    
        // Periksa apakah ada perubahan pada data
        $isUpdated = $ikanKeluar->isDirty();
    
        // Jika tidak ada perubahan, kembalikan dengan pesan info
        if (!$isUpdated) {
            return redirect()->route('admin.pengelolaanIkan.index')->with('info', 'No changes were made to the outcoming fish data.');
        }
    
        // Simpan perubahan data ikan keluar
        $ikanKeluar->save();
    
        // Redirect dengan pesan sukses
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
