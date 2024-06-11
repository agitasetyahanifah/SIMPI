<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use App\Models\SewaSpot;
use App\Models\User;
use App\Models\Spot;

class AdminSewaPemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $sewaPemancingan = SewaSpot::orderBy('tanggal_sewa', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
    //     $lastItem = $sewaPemancingan->lastItem();
    //     $member = User::where('role', 'member')->get();
    //     $members = User::where('role', 'member')->orderBy('nama', 'asc')->get(); 
    //     $allSpots = Spot::all();
    //     $sewaSpots = SewaSpot::pluck('spot_id')->toArray();
    //     $availableSpots = Spot::whereNotIn('id', $sewaSpots)->get(); 
      
    //     return view('admin.sewapemancingan.index', compact('sewaPemancingan', 'lastItem', 'member', 'members','allSpots', 'sewaSpots', 'availableSpots'));
    // }

    public function index(Request $request)
    {
        $sewaPemancingan = SewaSpot::orderBy('tanggal_sewa', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
        $lastItem = $sewaPemancingan->lastItem();
        $member = User::where('role', 'member')->get();
        $members = User::where('role', 'member')->orderBy('nama', 'asc')->get(); 
        $allSpots = Spot::all();
    
        // Mengambil tanggal sewa dari request
        $tanggalSewa = $request->input('tanggal_sewa', date('Y-m-d'));
    
        // Mendapatkan spot-spot yang tersedia pada tanggal sewa tertentu
        $availableSpots = $this->getAvailableSpots($tanggalSewa);
    
        // Menyediakan data sesi untuk spot-spot yang tersedia pada tanggal sewa
        $availableSessions = [];
        foreach ($availableSpots as $spot) {
            // Mendapatkan sesi yang tersedia untuk setiap spot pada tanggal sewa
            $availableSessions[$spot->id] = $this->getAvailableSessions($spot->id, $tanggalSewa);
        }
    
        // Menyediakan data untuk dipass ke view
        return view('admin.sewapemancingan.index', compact('sewaPemancingan', 'lastItem', 'member', 'members', 'allSpots', 'tanggalSewa', 'availableSpots', 'availableSessions'));
    }
    
    private function getAvailableSpots($tanggalSewa)
    {
        // Mendapatkan spot-spot yang telah disewa pada tanggal tersebut
        $sewaSpots = SewaSpot::whereDate('tanggal_sewa', $tanggalSewa)->pluck('spot_id')->toArray();
    
        // Mengambil spot-spot yang tersedia pada tanggal tersebut
        return Spot::whereNotIn('id', $sewaSpots)->get();
    }
    
    private function getAvailableSessions($spotId, $tanggalSewa)
    {
        // Mendapatkan sesi yang telah disewa pada spot dan tanggal sewa tertentu
        $sewaSessions = SewaSpot::where('spot_id', $spotId)->whereDate('tanggal_sewa', $tanggalSewa)->pluck('sesi')->toArray();
    
        // Mengembalikan sesi yang tersedia pada spot dan tanggal sewa tertentu
        return array_diff(['08.00-12.00', '13.00-17.00'], $sewaSessions);
    }
    
    

    // public function search(Request $request)
    // {
    //     $query = SewaSpot::query();
        
    //     if ($request->filled('kode_booking')) {
    //         $kodeBooking = $request->input('kode_booking');
    //         Log::info('Searching by kode_booking: ' . $kodeBooking);
    //         $query->where('kode_booking', 'like', '%' . $kodeBooking . '%');
    //     }
    //     if ($request->filled('nama_pelanggan')) {
    //         $namaPelanggan = $request->input('nama_pelanggan');
    //         Log::info('Searching by nama_pelanggan: ' . $namaPelanggan);
    //         $query->whereHas('user', function ($q) use ($namaPelanggan) {
    //             $q->where('nama', 'like', '%' . $namaPelanggan . '%');
    //         });
    //     }        
        
    //     $sewaPemancingan = $query->orderBy('tanggal_sewa', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
    //     Log::info('Search results: ', $sewaPemancingan->toArray());
        
    //     return view('admin.sewapemancingan.index', compact('sewaPemancingan'));
    // }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        // Query untuk mencari data berdasarkan keyword
        $sewaPemancingan = Sewaspot::where('kode_booking', 'like', "%$keyword%")
            ->whereHas('member', function ($query) use ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                    ->where('role', 'member');
            })
            ->orWhereHas('member', function ($query) use ($keyword) {
                $query->where('role', 'member');
            })
            ->get();
            
        // Kirim data pencarian ke view
        return view('admin.sewapemancingan.index', compact('sewaPemancingan'));
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
    //     // Validasi data yang diterima dari form
    //     $validatedData = $request->validate([
    //         'nama_pelanggan' => 'required|exists:user,id',
    //         'tanggal_sewa' => 'required|date',
    //         'jam_mulai' => 'required|date_format:H:i',
    //         'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    //     ]);

    //     // Get the authenticated user's ID
    //     // $userId = Auth::id();
    
    //     // Contoh untuk mengecek apakah jam yang dipilih sudah dipesan atau tidak
    //     $jamMulai = \Carbon\Carbon::parse($validatedData['jam_mulai']);
    //     $jamSelesai = \Carbon\Carbon::parse($validatedData['jam_selesai']);
    //     $isTimeAvailable = !SewaSpot::where('tanggal_sewa', $validatedData['tanggal_sewa'])
    //                      ->where(function ($query) use ($jamMulai, $jamSelesai) {
    //                          $query->where(function ($q) use ($jamMulai, $jamSelesai) {
    //                              $q->where('jam_mulai', '>=', $jamMulai)
    //                                  ->where('jam_mulai', '<', $jamSelesai);
    //                          })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
    //                              $q->where('jam_selesai', '>', $jamMulai)
    //                                  ->where('jam_selesai', '<=', $jamSelesai);
    //                          });
    //                      })
    //                      ->exists();
    
    //     if (!$isTimeAvailable) {
    //         return redirect()->back()->with('error', 'Waktu yang dipilih sudah dipesan.');
    //     }
    
    //     // Hitung selisih waktu dalam detik
    //     $selisihDetik = $jamSelesai->diffInSeconds($jamMulai);

    //     // Konversi selisih waktu ke jam (termasuk menit dan detik)
    //     $selisihJam = $selisihDetik / 3600;
    
    //     // Ambil harga sewa per jam (contoh: 10 ribu per jam)
    //     $hargaSewaPerJam = 10000; // Ganti dengan harga sewa yang sesuai
    
    //     // Hitung biaya sewa berdasarkan rumus
    //     $biayaSewa = $hargaSewaPerJam * $selisihJam;
    
    //     // Simpan data sewa pemancingan
    //     $sewaPemancingan = new SewaSpot();
    //     $sewaPemancingan->kode_booking = uniqid('BK');
    //     // $sewaPemancingan->user_id = $userId;
    //     $sewaPemancingan->user_id = $validatedData['nama_pelanggan'];
    //     $sewaPemancingan->tanggal_sewa = $validatedData['tanggal_sewa'];
    //     $sewaPemancingan->jam_mulai = $validatedData['jam_mulai'];
    //     $sewaPemancingan->jam_selesai = $validatedData['jam_selesai'];
    //     $sewaPemancingan->biaya_sewa = $biayaSewa;
    //     $sewaPemancingan->save();
    
    //     // Redirect atau berikan respons sesuai kebutuhan Anda
    //     return redirect()->back()->with('success', 'Data sewa pemancingan berhasil disimpan.');
    // }

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
        $validatedData = $request->validate([
            'edit_tanggal_sewa' => 'required|date|after_or_equal:today',
            'edit_spot_id' => 'required|integer|exists:spots,id',
            'edit_sesi' => 'required|string|in:08.00-12.00,13.00-17.00',
        ]);
    
        $tanggalSewa = $validatedData['edit_tanggal_sewa'];
        $spotId = $validatedData['edit_spot_id'];
        $sesi = $validatedData['edit_sesi'];
    
        // Cek apakah spot sudah dipesan
        $isSpotBooked = SewaSpot::where('tanggal_sewa', $tanggalSewa)
            ->where('spot_id', $spotId)
            ->where('sesi', $sesi)
            ->exists();
    
        if ($isSpotBooked) {
            return redirect()->back()->withErrors(['error' => 'Spot atau sesi yang dipilih sudah dipesan.']);
        }
    
        // Update data sewa pemancingan
        $sewaPemancingan = SewaSpot::findOrFail($id);
        $sewaPemancingan->tanggal_sewa = $tanggalSewa;
        $sewaPemancingan->spot_id = $spotId;
        $sewaPemancingan->sesi = $sesi;
        $sewaPemancingan->save();
    
        return redirect()->back()->with('success', 'Data sewa pemancingan berhasil diupdate.');
    }
    
    // public function checkAvailability(Request $request)
    // {
    //     $tanggalSewa = $request->input('tanggal_sewa');
    //     $selectedDate = Carbon::parse($tanggalSewa)->format('Y-m-d');
    
    //     // Fetch all spot IDs
    //     $allSpots = Spot::pluck('id')->toArray();
    
    //     // Fetch spot IDs that are already booked on the selected date
    //     $bookedSpots = SewaSpot::whereDate('tanggal_sewa', $selectedDate)
    //         ->join('spots', 'sewa_spots.spot_id', '=', 'spots.id')
    //         ->pluck('spots.id')
    //         ->toArray();
    
    //     // Calculate available spots by removing booked spots from all spots
    //     $availableSpots = array_diff($allSpots, $bookedSpots);
    
    //     // Determine available sessions for each spot
    //     $availableSessions = [];
    //     foreach ($availableSpots as $spotId) {
    //         $sessions = [
    //             '08.00-12.00' => SewaSpot::where('tanggal_sewa', $selectedDate)
    //                                     ->where('spot_id', $spotId)
    //                                     ->where('sesi', '08.00-12.00')
    //                                     ->doesntExist(),
    //             '13.00-17.00' => SewaSpot::where('tanggal_sewa', $selectedDate)
    //                                     ->where('spot_id', $spotId)
    //                                     ->where('sesi', '13.00-17.00')
    //                                     ->doesntExist()
    //         ];
    
    //         // Filter available sessions
    //         $availableSessions[$spotId] = array_keys(array_filter($sessions));
    //     }
    
    //     return new JsonResponse([
    //         'availableSpots' => $availableSpots,
    //         'availableSessions' => $availableSessions
    //     ]);
    // }

    public function checkAvailability(Request $request)
    {
        $tanggalSewa = $request->query('edit_tanggal_sewa');
        $selectedDate = Carbon::parse($tanggalSewa)->format('Y-m-d');
    
        // Ambil ID spot yang sudah dipesan pada tanggal yang dipilih
        $bookedSpots = SewaSpot::whereDate('tanggal_sewa', $selectedDate)
            ->pluck('spot_id')
            ->toArray();
    
        // Ambil spot yang tersedia dengan mengeluarkan spot yang sudah dipesan
        $availableSpots = Spot::whereNotIn('id', $bookedSpots)
            ->pluck('nomor_spot', 'id')
            ->toArray();
    
        // Tentukan sesi yang tersedia untuk setiap spot yang tersedia
        $availableSessions = [];
        foreach ($availableSpots as $spotId => $spotNomor) {
            $sessions = [
                '08.00-12.00' => SewaSpot::where('tanggal_sewa', $selectedDate)
                                        ->where('spot_id', $spotId)
                                        ->where('sesi', '08.00-12.00')
                                        ->doesntExist(),
                '13.00-17.00' => SewaSpot::where('tanggal_sewa', $selectedDate)
                                        ->where('spot_id', $spotId)
                                        ->where('sesi', '13.00-17.00')
                                        ->doesntExist()
            ];
    
            // Filter sesi yang tersedia
            $availableSessions[$spotId] = array_keys(array_filter($sessions));
        }
    
        return response()->json([
            'availableSpots' => $availableSpots,
            'availableSessions' => $availableSessions
        ]);
    }
    
    // public function checkAvailability(Request $request)
    // {
    //     $tanggalSewa = $request->input('tanggal_sewa');
    //     $selectedDate = Carbon::parse($tanggalSewa)->format('Y-m-d');
    
    //     // Fetch all spot IDs
    //     $allSpots = Spot::pluck('nomor_spot')->toArray();
    
    //     // Fetch spot IDs that are already booked on the selected date
    //     $bookedSpots = SewaSpot::whereDate('tanggal_sewa', $selectedDate)
    //         ->pluck('spot_id')
    //         ->toArray();
    
    //     // Calculate available spots by removing booked spots from all spots
    //     $availableSpots = array_diff($allSpots, $bookedSpots);
    
    //     return new JsonResponse(['availableSpots' => $availableSpots]);
    // }    
    
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


    // public function getAvailableSpots(Request $request)
    // {
    //     $date = $request->input('date');
    //     $pemancinganId = $request->input('pemancingan_id');
    
    //     // Query to get spots that are not booked on the given date except the current booking
    //     $availableSpots = Spot::whereDoesntHave('sewaSpots', function ($query) use ($date, $pemancinganId) {
    //         $query->whereDate('tanggal', $date)
    //               ->where('id', '!=', $pemancinganId);
    //     })->get(['id', 'nomor_spot']);
    
    //     return response()->json($availableSpots);
    // }
    
    // public function getAvailableSessions(Request $request)
    // {
    //     $date = $request->input('date');
    //     $spotId = $request->input('spot_id');
    //     $pemancinganId = $request->input('pemancingan_id');
    
    //     // Default sessions
    //     $sessions = ['08:00-12:00', '13:00-17:00'];
    
    //     // Query to get booked sessions for the given spot and date except the current booking
    //     $bookedSessions = SewaSpot::where('spot_id', $spotId)
    //                                 ->whereDate('tanggal', $date)
    //                                 ->where('id', '!=', $pemancinganId)
    //                                 ->pluck('sesi')->toArray();
    
    //     // Filter available sessions
    //     $availableSessions = array_diff($sessions, $bookedSessions);
    
    //     return response()->json($availableSessions);
    // }

}
