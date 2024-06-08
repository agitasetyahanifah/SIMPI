<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SewaSpot;
use App\Models\Spot;

class MemberSewaSpotController extends Controller
{
    public function index()
    {
        $spots = Spot::all();
        // $sewaSpots = SewaSpot::all()->groupBy('spot_id');
        $sewaSpots = SewaSpot::where('tanggal_sewa', '>=', Carbon::today())->get()->groupBy('spot_id');
        return view('member.sewaspotpemancingan.sewa-spot', compact('spots', 'sewaSpots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'spot_id' => 'required|exists:spots,id',
            'tanggal_sewa' => 'required|date',
            'sesi' => 'required|in:08.00-12.00,13.00-17.00',
        ]);

        // Periksa apakah spot pada sesi dan tanggal tersebut sudah dipesan
        $spotBooked = SewaSpot::where('spot_id', $request->spot_id)
            ->where('tanggal_sewa', $request->tanggal_sewa)
            ->where('sesi', $request->sesi)
            ->exists();

        // Jika spot sudah dipesan, kembalikan dengan pesan error
        if ($spotBooked) {
            return back()->withErrors(['sesi' => 'Sesi ini sudah tidak tersedia. Silakan pilih sesi lain.']);
        }

        $biaya_sewa = 10000;

        DB::transaction(function () use ($request, $biaya_sewa) {
            $sewaSpot = SewaSpot::create([
                'user_id' => Auth::id(),
                'tanggal_sewa' => $request->tanggal_sewa,
                'sesi' => $request->sesi,
                'spot_id' => $request->spot_id,
                'biaya_sewa' => $biaya_sewa,
                'status' => 'menunggu pembayaran',
            ]);

            // Tambahkan kode untuk mengatur pembatalan otomatis pesanan
            $timeout = Carbon::now()->addHours(24); // Waktu timeout 24 jam dari sekarang
            $sewaSpot->update(['timeout' => $timeout]);
        });

        return redirect()->route('member.spots.index')->with('success', 'Spot berhasil dibooking!');
    }

    public function cancelOrder(SewaSpot $sewaSpot)
    {
        // Pastikan pesanan belum dibayar dan belum melewati timeout
        if ($sewaSpot->status === 'menunggu pembayaran' && Carbon::now()->lt($sewaSpot->timeout)) {
            // Ubah status pesanan menjadi "dibatalkan"
            $sewaSpot->status = 'dibatalkan';
            $sewaSpot->save();
    
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }
    
        return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
    }    

    public function resetSpot()
    {
        $currentHour = Carbon::now()->format('H:i');
        $spots = Spot::all();

        // Reset spot untuk sesi 08.00-12.00 pada pukul 12.00
        if ($currentHour === '12:00') {
            foreach ($spots as $spot) {
                $spot->sewaSpots()->where('sesi', '08.00-12.00')->delete();
            }
        }

        // Reset spot untuk sesi 13.00-17.00 pada pukul 17.00
        if ($currentHour === '17:00') {
            foreach ($spots as $spot) {
                $spot->sewaSpots()->where('sesi', '13.00-17.00')->delete();
            }
        }

        return redirect()->route('member.spots.index');
    }

    public function cekKetersediaan(Request $request)
    {
        $tanggalSewa = $request->query('tanggal_sewa');
        $spotId = $request->query('spot_id');

        // Logika untuk mendapatkan sesi yang sudah dipesan
        $bookedSessions = SewaSpot::where('tanggal_sewa', $tanggalSewa)
                                ->where('spot_id', $spotId)
                                ->pluck('sesi');

        return response()->json(['sesi_terpesan' => $bookedSessions]);
    }

    public function riwayatSewa()
    {
        // Ambil riwayat sewa terbaru berdasarkan user yang sedang login
        $user = Auth::user();
        $riwayatSewa = SewaSpot::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal sewa descending
                                ->get();
    
        // Kembalikan ke view dengan data riwayat sewa
        return view('member.sewaspotpemancingan.riwayat-sewa', compact('riwayatSewa'));
    }    

    public function autoCancel($id)
    {
        $sewa = SewaSpot::find($id);

        if ($sewa && $sewa->status === 'menunggu pembayaran') {
            $createdTime = $sewa->created_at;
            $currentTime = now();
            $hoursDifference = $createdTime->diffInHours($currentTime);

            if ($hoursDifference >= 24) {
                $sewa->status = 'dibatalkan';
                $sewa->save();
            }
        }

        return response()->json(['success' => true]);
    }

}