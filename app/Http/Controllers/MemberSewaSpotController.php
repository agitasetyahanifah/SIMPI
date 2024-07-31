<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SewaSpot;
use App\Models\Spot;
use App\Models\UpdateSesiSewaSpot;
use App\Models\UpdateHargaSewaSpot;

class MemberSewaSpotController extends Controller
{
    public function index()
    {
        // Mengambil semua sesi
        $sessions = UpdateSesiSewaSpot::all();

        // Mengambil harga member terbaru
        $latestMemberPrice = UpdateHargaSewaSpot::where('status_member', 'member')->latest()->first();
        $memberPrice = $latestMemberPrice ? $latestMemberPrice->harga : 0;
        $harga_id = $latestMemberPrice ? $latestMemberPrice->id : null;

        // Mengambil semua data spot
        $spots = Spot::all();
        // Mengambil data sewa spot yang tanggal sewanya lebih besar atau sama dengan hari ini, dan mengelompokkannya berdasarkan spot_id
        $sewaSpots = SewaSpot::where('tanggal_sewa', '>=', Carbon::today())->get()->groupBy('spot_id');
        
        // Mengembalikan view 'Member.SewaSpotPemancingan.sewa-spot' dengan data 'spots' dan 'sewaSpots'
        return view('Member.SewaSpotPemancingan.sewa-spot', compact('spots', 'sewaSpots', 'sessions', 'memberPrice','harga_id'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'spot_id' => 'required|exists:spots,id',
    //         'tanggal_sewa' => 'required|date',
    //         'sesi' => 'required|in:08.00-12.00,13.00-17.00',
    //     ]);

    //     // Periksa apakah spot pada sesi dan tanggal tersebut sudah dipesan
    //     $spotBooked = SewaSpot::where('spot_id', $request->spot_id)
    //         ->where('tanggal_sewa', $request->tanggal_sewa)
    //         ->where('sesi', $request->sesi)
    //         ->exists();

    //     // Jika spot sudah dipesan, kembalikan dengan pesan error
    //     if ($spotBooked) {
    //         return back()->withErrors(['sesi' => 'This session is no longer available. Please select another session.']);
    //     }

    //     $biaya_sewa = 10000;

    //     DB::transaction(function () use ($request, $biaya_sewa) {
    //         $sewaSpot = SewaSpot::create([
    //             'user_id' => Auth::id(),
    //             'tanggal_sewa' => $request->tanggal_sewa,
    //             'sesi' => $request->sesi,
    //             'spot_id' => $request->spot_id,
    //             'biaya_sewa' => $biaya_sewa,
    //             'status' => 'menunggu pembayaran',
    //         ]);

    //         // Tambahkan kode untuk mengatur pembatalan otomatis pesanan
    //         $timeout = Carbon::now()->addHours(24); // Waktu timeout 24 jam dari sekarang
    //         $sewaSpot->update(['timeout' => $timeout]);
    //     });

    //     return redirect()->route('member.spots.index')->with('success', 'Spot successfully booked!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'spot_id' => 'required|exists:spots,id',
            'tanggal_sewa' => 'required|date',
            'sesi_id' => 'required|exists:update_sesi_sewa_spots,id',
            'harga_id' => 'required|exists:update_harga_sewa_spots,id',
        ]);
    
        // Periksa apakah spot pada sesi dan tanggal tersebut sudah dipesan
        $spotBooked = SewaSpot::where('spot_id', $request->spot_id)
            ->where('tanggal_sewa', $request->tanggal_sewa)
            ->where('sesi_id', $request->sesi_id)
            ->whereIn('status', ['menunggu pembayaran', 'sudah dibayar'])
            ->exists();
    
        // Jika spot sudah dipesan, kembalikan dengan pesan error
        if ($spotBooked) {
            return back()->withErrors(['sesi_id' => 'This session is no longer available. Please select another session.']);
        }
    
        DB::transaction(function () use ($request) {
            $sewaSpot = SewaSpot::create([
                'user_id' => Auth::id(),
                'tanggal_sewa' => $request->tanggal_sewa,
                'sesi_id' => $request->sesi_id,
                'spot_id' => $request->spot_id,
                'harga_id' => $request->harga_id,
                'status' => 'menunggu pembayaran',
            ]);
    
            // Tambahkan kode untuk mengatur pembatalan otomatis pesanan
            $timeout = Carbon::now()->addHours(24); // Waktu timeout 24 jam dari sekarang
            $sewaSpot->update(['timeout' => $timeout]);
        });
    
        return redirect()->route('member.spots.index')->with('success', 'Spot successfully booked!');
    }

    public function cancelOrder(SewaSpot $sewaSpot)
    {
        // Pastikan pesanan belum dibayar dan belum melewati timeout
        if ($sewaSpot->status === 'menunggu pembayaran' && Carbon::now()->lt($sewaSpot->timeout)) {
            // Ubah status pesanan menjadi "dibatalkan"
            $sewaSpot->status = 'dibatalkan';
            $sewaSpot->status_kehadiran = 'tidak hadir';
            $sewaSpot->save();
    
            return redirect()->back()->with('success', 'Fishing Spot Booking has been successfully cancelled.');
        }
    
        return redirect()->back()->with('error', 'Fishing Spot Booking failed to be cancelled.');
    }

    // public function resetSpot()
    // {
    //     $currentHour = Carbon::now()->format('H:i');
    //     $spots = Spot::all();

    //     // Reset spot untuk sesi 08.00-12.00 pada pukul 12.00
    //     if ($currentHour === '12:00') {
    //         foreach ($spots as $spot) {
    //             $spot->sewaSpots()->where('sesi', '08.00-12.00')->delete();
    //         }
    //     }

    //     // Reset spot untuk sesi 13.00-17.00 pada pukul 17.00
    //     if ($currentHour === '17:00') {
    //         foreach ($spots as $spot) {
    //             $spot->sewaSpots()->where('sesi', '13.00-17.00')->delete();
    //         }
    //     }

    //     return redirect()->route('member.spots.index');
    // }

    // public function cekKetersediaan(Request $request)
    // {
    //     $tanggalSewa = $request->query('tanggal_sewa');
    //     $spotId = $request->query('spot_id');

    //     // Logika untuk mendapatkan sesi yang sudah dipesan
    //     $bookedSessions = SewaSpot::where('tanggal_sewa', $tanggalSewa)
    //                             ->where('spot_id', $spotId)
    //                             ->whereIn('status', ['menunggu pembayaran', 'sudah dibayar'])
    //                             ->pluck('sesi');

    //     return response()->json(['sesi_terpesan' => $bookedSessions]);
    // }

    public function riwayatSewa()
    {
        // Ambil riwayat sewa terbaru berdasarkan user yang sedang login
        $user = Auth::user();
        $riwayatSewa = SewaSpot::where('user_id', $user->id)
                                ->with([
                                    'updateSesiSewaSpot',
                                    'updateHargaSewaSpot' => function ($query) {
                                        $query->where('status_member', 'member')
                                              ->orderBy('created_at', 'desc');
                                    }
                                ])
                                ->orderBy('created_at', 'desc')
                                ->paginate(15);
        $lastItem = $riwayatSewa->lastItem();
    
        // Kembalikan ke view dengan data riwayat sewa
        return view('Member.SewaSpotPemancingan.riwayat-sewa', compact('riwayatSewa', 'lastItem'));
    }    

    public function autoCancel($id)
    {
        $sewa = SewaSpot::findOrFail($id);

        if ($sewa && $sewa->status === 'menunggu pembayaran') {
            $createdTime = $sewa->created_at;
            $currentTime = now();
            $hoursDifference = $createdTime->diffInHours($currentTime);

            if ($hoursDifference >= 24) {
                $sewa->status = 'dibatalkan';
                $sewa->status_kehadiran = 'tidak hadir';
                $sewa->save();
            }
        }

        return response()->json(['success' => true]);
    }   
    
    public function checkAvailability(Request $request)
    {
        $spotId = $request->query('spot_id');
        $selectedDate = $request->query('tanggal_sewa');
    
        if (!$spotId || !$selectedDate) {
            return response()->json(['disabled_sesi' => [], 'available_spots' => []]);
        }
    
        $spot = Spot::find($spotId);
    
        if (!$spot) {
            return response()->json(['disabled_sesi' => [], 'available_spots' => []]);
        }
    
        $unavailableSessions = $spot->getUnavailableSessions($selectedDate);
    
        // Mengambil semua spot
        $allSpots = Spot::pluck('id')->toArray();
        $availableSpots = [];
    
        foreach ($allSpots as $id) {
            $currentSpot = Spot::find($id);
            $availableSessions = $currentSpot->getAvailableSessions($selectedDate);
            if (!empty($availableSessions)) {
                $availableSpots[] = $id;
            }
        }
    
        return response()->json([
            'disabled_sesi' => $unavailableSessions,
            'available_spots' => $availableSpots,
        ]);
    }

}