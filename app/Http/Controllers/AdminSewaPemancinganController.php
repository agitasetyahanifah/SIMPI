<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SewaPemancingan;

class AdminSewaPemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sewaPemancingan = SewaPemancingan::orderBy('tanggal_sewa', 'desc')->paginate(25);
        $lastItem = $sewaPemancingan->lastItem();
        $member = Member::all();
        return view('admin.sewapemancingan.index', compact('sewaPemancingan', 'lastItem', 'member'));
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
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'tanggal_sewa' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jumlah_sewa' => 'required|integer|min:1',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();
    
        // Contoh untuk mengecek apakah jam yang dipilih sudah dipesan atau tidak
        $jamMulai = \Carbon\Carbon::parse($validatedData['jam_mulai']);
        $jamSelesai = \Carbon\Carbon::parse($validatedData['jam_selesai']);
        $isTimeAvailable = !SewaPemancingan::where('tanggal_sewa', $validatedData['tanggal_sewa'])
                         ->where(function ($query) use ($jamMulai, $jamSelesai) {
                             $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                                 $q->where('jam_mulai', '>=', $jamMulai)
                                     ->where('jam_mulai', '<', $jamSelesai);
                             })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                                 $q->where('jam_selesai', '>', $jamMulai)
                                     ->where('jam_selesai', '<=', $jamSelesai);
                             });
                         })
                         ->exists();
    
        if (!$isTimeAvailable) {
            return redirect()->back()->with('error', 'Waktu yang dipilih sudah dipesan.');
        }
    
        // Hitung selisih waktu dalam jam
        $selisihJam = $jamSelesai->diffInHours($jamMulai);
    
        // Ambil harga sewa per jam (contoh: 10 ribu per jam)
        $hargaSewaPerJam = 10000; // Ganti dengan harga sewa yang sesuai
    
        // Hitung biaya sewa berdasarkan rumus
        $biayaSewa = $hargaSewaPerJam * $selisihJam;
    
        // Simpan data sewa pemancingan
        $sewaPemancingan = new SewaPemancingan();
        $sewaPemancingan->kode_booking = uniqid('BK');
        $sewaPemancingan->user_id = $userId;
        $sewaPemancingan->tanggal_sewa = $validatedData['tanggal_sewa'];
        $sewaPemancingan->jam_mulai = $validatedData['jam_mulai'];
        $sewaPemancingan->jam_selesai = $validatedData['jam_selesai'];
        $sewaPemancingan->jumlah_sewa = $validatedData['jumlah_sewa'];
        $sewaPemancingan->biaya_sewa = $biayaSewa;
        $sewaPemancingan->save();
    
        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Data sewa pemancingan berhasil disimpan.');
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
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'edit_tanggal_sewa' => 'required|date',
            'edit_jam_mulai' => 'required|date_format:H:i',
            'edit_jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'edit_jumlah_sewa' => 'required|integer|min:1',
        ]);
        
        // Cari data sewa pemancingan berdasarkan ID
        $sewaPemancingan = SewaPemancingan::findOrFail($id);
    
        // Update data sewa pemancingan
        $sewaPemancingan->tanggal_sewa = $validatedData['edit_tanggal_sewa'];
        $sewaPemancingan->jam_mulai = $validatedData['edit_jam_mulai'];
        $sewaPemancingan->jam_selesai = $validatedData['edit_jam_selesai'];
        $sewaPemancingan->jumlah_sewa = $validatedData['edit_jumlah_sewa'];

         // Hitung selisih waktu dalam jam
        $jamMulai = \Carbon\Carbon::parse($validatedData['edit_jam_mulai']);
        $jamSelesai = \Carbon\Carbon::parse($validatedData['edit_jam_selesai']);
        $selisihJam = $jamSelesai->diffInHours($jamMulai);

        // Ambil harga sewa per jam (misal: 10 ribu per jam)
        $hargaSewaPerJam = 10000; // Ganti dengan harga sewa yang sesuai

        // Hitung biaya sewa berdasarkan rumus
        $biayaSewa = $hargaSewaPerJam * $selisihJam * $validatedData['edit_jumlah_sewa'];

        // Update biaya sewa dalam database
        $sewaPemancingan->biaya_sewa = $biayaSewa;
        $sewaPemancingan->save();

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Data sewa pemancingan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sewaPemancingan = SewaPemancingan::findOrFail($id);
            
        // Hapus alat pancing dari database
        $sewaPemancingan->delete();
            
        // Redirect kembali ke halaman sewa pemancingan dengan pesan sukses
        return redirect()->back()->with('success', 'Data Penyewaan Pemancingan berhasil dihapus.');
    }
}
