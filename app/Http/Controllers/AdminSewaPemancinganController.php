<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SewaSpot;
use App\Models\User;

class AdminSewaPemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sewaPemancingan = SewaSpot::orderBy('tanggal_sewa', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
        $lastItem = $sewaPemancingan->lastItem();
        $member = User::where('role', 'member')->get();
        $members = User::where('role', 'member')->orderBy('nama', 'asc')->get();        
        return view('admin.sewapemancingan.index', compact('sewaPemancingan', 'lastItem', 'member', 'members'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $sewaPemancingan = SewaSpot::where(function ($query) use ($search) {
            $query->where('kode_booking', 'like', '%' . $search . '%')
                  ->orWhereHas('member', function($subquery) use ($search) {
                      $subquery->where('nama', 'like', '%' . $search . '%');
                  });
        })->orderBy('tanggal_sewa', 'desc')->paginate(25);
        
        return response()->json($sewaPemancingan);
    
    }      

    // public function search(Request $request)
    // {
    //     $search = $request->input('search');
    //     $sewaPemancingan = SewaSpot::whereHas('member', function($query) use ($search) {
    //         $query->where('nama', 'like', '%' . $search . '%');
    //     })
    //     ->orWhere('kode_booking', 'like', '%' . $search . '%')
    //     ->with('member')
    //     ->get();

    //     return response()->json([
    //         'data' => $sewaPemancingan,
    //     ]);
    // }

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
            'nama_pelanggan' => 'required|exists:user,id',
            'tanggal_sewa' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Get the authenticated user's ID
        // $userId = Auth::id();
    
        // Contoh untuk mengecek apakah jam yang dipilih sudah dipesan atau tidak
        $jamMulai = \Carbon\Carbon::parse($validatedData['jam_mulai']);
        $jamSelesai = \Carbon\Carbon::parse($validatedData['jam_selesai']);
        $isTimeAvailable = !SewaSpot::where('tanggal_sewa', $validatedData['tanggal_sewa'])
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
    
        // Hitung selisih waktu dalam detik
        $selisihDetik = $jamSelesai->diffInSeconds($jamMulai);

        // Konversi selisih waktu ke jam (termasuk menit dan detik)
        $selisihJam = $selisihDetik / 3600;
    
        // Ambil harga sewa per jam (contoh: 10 ribu per jam)
        $hargaSewaPerJam = 10000; // Ganti dengan harga sewa yang sesuai
    
        // Hitung biaya sewa berdasarkan rumus
        $biayaSewa = $hargaSewaPerJam * $selisihJam;
    
        // Simpan data sewa pemancingan
        $sewaPemancingan = new SewaSpot();
        $sewaPemancingan->kode_booking = uniqid('BK');
        // $sewaPemancingan->user_id = $userId;
        $sewaPemancingan->user_id = $validatedData['nama_pelanggan'];
        $sewaPemancingan->tanggal_sewa = $validatedData['tanggal_sewa'];
        $sewaPemancingan->jam_mulai = $validatedData['jam_mulai'];
        $sewaPemancingan->jam_selesai = $validatedData['jam_selesai'];
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
        ]);
        
        // Cari data sewa pemancingan berdasarkan ID
        $sewaPemancingan = SewaSpot::findOrFail($id);
    
        // Update data sewa pemancingan
        $sewaPemancingan->tanggal_sewa = $validatedData['edit_tanggal_sewa'];
        $sewaPemancingan->jam_mulai = $validatedData['edit_jam_mulai'];
        $sewaPemancingan->jam_selesai = $validatedData['edit_jam_selesai'];

         // Hitung selisih waktu dalam jam
        $jamMulai = \Carbon\Carbon::parse($validatedData['edit_jam_mulai']);
        $jamSelesai = \Carbon\Carbon::parse($validatedData['edit_jam_selesai']);
        
        // Hitung selisih waktu dalam detik
        $selisihDetik = $jamSelesai->diffInSeconds($jamMulai);

        // Konversi selisih waktu ke jam (termasuk menit dan detik)
        $selisihJam = $selisihDetik / 3600;

        // Ambil harga sewa per jam (misal: 10 ribu per jam)
        $hargaSewaPerJam = 10000; // Ganti dengan harga sewa yang sesuai

        // Hitung biaya sewa berdasarkan rumus
        $biayaSewa = $hargaSewaPerJam * $selisihJam;

        // Update biaya sewa dalam database
        $sewaPemancingan->biaya_sewa = $biayaSewa;
        
        // Update biaya sewa dan status dalam database
        $sewaPemancingan->biaya_sewa = $biayaSewa;
        $sewaPemancingan->status = 'menunggu pembayaran';
        $sewaPemancingan->save();

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Data sewa pemancingan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sewaPemancingan = SewaSpot::findOrFail($id);
            
        // Hapus alat pancing dari database
        $sewaPemancingan->delete();
            
        // Redirect kembali ke halaman sewa pemancingan dengan pesan sukses
        return redirect()->back()->with('success', 'Data penyewaan pemancingan berhasil dihapus.');
    }

    public function konfirmasiPembayaran($id, Request $request)
    {
        $pemancingan = SewaSpot::findOrFail($id);

        // Periksa apakah status sudah 'sudah dibayar'
        if ($pemancingan->status === 'sudah dibayar') {
            return redirect()->back()->with('error', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }

        // Perbarui status pembayaran
        $pemancingan->status = $request->status;
        $pemancingan->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

}
