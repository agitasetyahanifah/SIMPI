<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenyewaanAlat;
use App\Models\AlatPancing;
use App\Models\AlatPancingPenyewaanAlat;
use Illuminate\Support\Facades\DB;

class AdminPenyewaanAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alatPancing = AlatPancing::all();
        $penyewaanAlat = PenyewaanAlat::orderBy('created_at', 'desc')->paginate(20);
        $lastItem = $penyewaanAlat->lastItem();
        $alatPancingIds = $alatPancing->pluck('id')->toArray();
        return view('admin.penyewaanalat.index', compact('penyewaanAlat', 'alatPancing','lastItem', 'alatPancingIds'));
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
    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $validatedData = $request->validate([
    //         'nama_pelanggan' => 'required|string|max:255',
    //         'alat_pancing_id' => 'required|array',
    //         'alat_pancing_id.*' => 'exists:alat_pancing,id',
    //         'tanggal_pinjam' => 'required|date',
    //         'masa_pinjam' => 'required|numeric|min:1',
    //     ]);
    
    //     // Mulai transaksi database
    //     DB::beginTransaction();
    
    //     try {
    //         // Inisialisasi harga total
    //         $hargaTotal = 0;
    
    //         // Iterasi melalui setiap ID alat pancing yang dipilih
    //         foreach ($validatedData['alat_pancing_id'] as $idAlat) {
    //             // Cari alat pancing berdasarkan ID
    //             $alatPancing = AlatPancing::findOrFail($idAlat);
    
    //             // Tambahkan harga alat pancing ke harga total
    //             $hargaTotal += $alatPancing->harga;
    //         }
    
    //         // Hitung biaya sewa berdasarkan rumus
    //         $biayaSewa = $hargaTotal * $validatedData['masa_pinjam'];
    
    //         // Simpan data penyewaan alat ke dalam database
    //         $penyewaanAlat = new PenyewaanAlat();
    //         $penyewaanAlat->nama_pelanggan = $validatedData['nama_pelanggan'];
    //         $penyewaanAlat->tgl_pinjam = $validatedData['tanggal_pinjam'];
    //         $penyewaanAlat->tgl_kembali = date('Y-m-d', strtotime($validatedData['tanggal_pinjam'] . ' + ' . $validatedData['masa_pinjam'] . ' days'));
    //         $penyewaanAlat->biaya_sewa = $biayaSewa; // Assign nilai biaya_sewa
    //         $penyewaanAlat->status = 'sewa';
    //         $penyewaanAlat->save();
    
    //         // Simpan data alat pancing yang terkait dengan penyewaan alat
    //         foreach ($validatedData['alat_pancing_id'] as $alatId) {
    //             $penyewaanAlat->alatPancing()->attach($alatId);
    //         }
    
    //         // Commit transaksi jika tidak ada masalah
    //         DB::commit();
    
    //         // Redirect kembali dengan pesan sukses
    //         return redirect()->back()->with('success', 'Data Penyewaan alat berhasil ditambahkan.');
    //     } catch (\Exception $e) {
    //         dd($e->getMessage());
    //         // Rollback transaksi jika terjadi kesalahan
    //         DB::rollback();
    
    //         // Redirect kembali dengan pesan error
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    //     }
    // } 

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $validatedData = $request->validate([
    //         'nama_pelanggan' => 'required|string|max:255',
    //         'alat_pancing_id' => 'required|array',
    //         'alat_pancing_id.*' => 'exists:alat_pancing,id',
    //         'tanggal_pinjam' => 'required|date',
    //         'masa_pinjam' => 'required|numeric|min:1',
    //     ]);
    
    //     // Mulai transaksi database
    //     DB::beginTransaction();
    
    //     try {
    //         // Simpan data penyewaan alat ke dalam database
    //         $penyewaanAlat = new PenyewaanAlat();
    //         $penyewaanAlat->nama_pelanggan = $validatedData['nama_pelanggan'];
    //         $penyewaanAlat->tgl_pinjam = $validatedData['tanggal_pinjam'];
    //         $penyewaanAlat->tgl_kembali = date('Y-m-d', strtotime($validatedData['tanggal_pinjam'] . ' + ' . $validatedData['masa_pinjam'] . ' days'));
    //         $penyewaanAlat->status = 'sewa';
    //         $penyewaanAlat->save();
    
    //         // Simpan data alat pancing yang terkait dengan penyewaan alat
    //         $penyewaanAlat->alatPancing()->sync($validatedData['alat_pancing_id']);
    
    //         // Hitung biaya sewa berdasarkan rumus
    //         $hargaTotal = $penyewaanAlat->alatPancing()->sum('harga');
    //         $biayaSewa = $hargaTotal * $validatedData['masa_pinjam'];
    //         $penyewaanAlat->biaya_sewa = $biayaSewa; // Assign nilai biaya_sewa
    //         $penyewaanAlat->save();
    
    //         // Commit transaksi jika tidak ada masalah
    //         DB::commit();
    
    //         // Redirect kembali dengan pesan sukses
    //         return redirect()->back()->with('success', 'Data Penyewaan alat berhasil ditambahkan.');
    //     } catch (\Exception $e) {
    //         // Rollback transaksi jika terjadi kesalahan
    //         DB::rollback();
    
    //         // Redirect kembali dengan pesan error
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    //     }
    // }    

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alat_pancing_id' => 'required|array',
            'alat_pancing_id.*' => 'exists:alat_pancing,id',
            'tanggal_pinjam' => 'required|date',
            'masa_pinjam' => 'required|numeric|min:1',
            'biaya_sewa' => 'required|numeric|min:0',
        ]);
    
        // Mulai transaksi database
        DB::beginTransaction();
    
        try {
            // Simpan data penyewaan alat ke dalam database
            $penyewaanAlat = new PenyewaanAlat();
            $penyewaanAlat->nama_pelanggan = $validatedData['nama_pelanggan'];
            $penyewaanAlat->tgl_pinjam = $validatedData['tanggal_pinjam'];
            $penyewaanAlat->tgl_kembali = date('Y-m-d', strtotime($validatedData['tanggal_pinjam'] . ' + ' . $validatedData['masa_pinjam'] . ' days'));
            $penyewaanAlat->biaya_sewa = str_replace('.', '', $validatedData['biaya_sewa']);
            $penyewaanAlat->status = 'sewa';
            $penyewaanAlat->save();

            // Simpan relasi alat pancing yang dipilih ke dalam tabel pivot
            $penyewaanAlat->alatPancing()->attach($validatedData['alat_pancing_id']);
    
            // Simpan data alat pancing yang terkait dengan penyewaan alat
            // $penyewaanAlat->alatPancing()->attach($validatedData['alat_pancing_id']);
    
            // Commit transaksi jika tidak ada masalah
            DB::commit();
    
            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Data Penyewaan alat berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();
    
            // Tampilkan pesan error
            dd($e->getMessage());
    
            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
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
        $penyewaanAlat = PenyewaanAlat::findOrFail($id);
            
        // Hapus alat pancing dari database
        $penyewaanAlat->delete();
            
        // Redirect kembali ke halaman daftar penyewaan alat dengan pesan sukses
        return redirect()->back()->with('success', 'Data penyewaan alat berhasil dihapus.');
    }  
}
