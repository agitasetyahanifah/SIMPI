<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AlatPancing;
use App\Models\SewaAlat;
use Carbon\Carbon;

class MemberDaftarAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alatPancing = AlatPancing::orderBy('created_at', 'desc')->paginate(18);
        $lastItem = $alatPancing->lastItem();
        return view('member.daftaralat.daftar-alat', compact('alatPancing','lastItem'));    
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
        // dd($request->all()); 
        // Validate the form data
        $validatedData = $request->validate([
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Calculate the rental duration in days
        $tglPinjam = new \DateTime($validatedData['tgl_pinjam']);
        $tglKembali = new \DateTime($validatedData['tgl_kembali']);
        $rentalDays = $tglPinjam->diff($tglKembali)->days;

        // Check if rental duration is 0 (same date), set it to 1 day
        if ($rentalDays === 0) {
            $rentalDays = 1;
        }

        // Get the rental price and quantity from the form
        $alatPancing = AlatPancing::findOrFail($request->input('alat_id'));
        $hargaSewa = $alatPancing->harga;
        $jumlah = $validatedData['jumlah'];

        // Calculate the total rental cost (biaya_sewa)
        $biayaSewa = $hargaSewa * $rentalDays * $jumlah;

        // Create a new SewaAlat instance
        $sewa = new SewaAlat();
        $sewa->kode_sewa = strtoupper('LN' . uniqid());
        $sewa->user_id = auth()->id();
        $sewa->alat_id = $alatPancing->id;
        $sewa->tgl_pinjam = $validatedData['tgl_pinjam'];
        $sewa->tgl_kembali = $validatedData['tgl_kembali'];
        $sewa->biaya_sewa = $biayaSewa;
        $sewa->jumlah = $jumlah;
        $sewa->status = 'menunggu pembayaran';
        $sewa->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Sewa alat pancing berhasil!');
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
        //
    }

    public function riwayatSewaAlat()
    {
        // Ambil riwayat sewa terbaru berdasarkan user yang sedang login
        $user = Auth::user();
        $riwayatSewaAlat = SewaAlat::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->get();
    
        // Kembalikan ke view dengan data riwayat sewa
        return view('member.daftaralat.riwayat-sewa-alat', compact('riwayatSewaAlat'));
    }

    public function cancelOrder(Sewaalat $sewaAlat)
    {
        // Pastikan pesanan belum dibayar dan belum melewati timeout
        if ($sewaAlat->status === 'menunggu pembayaran' && Carbon::now()->lt($sewaAlat->timeout)) {
            // Ubah status pesanan menjadi "dibatalkan"
            $sewaAlat->status = 'dibatalkan';
            $sewaAlat->save();
    
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }
    
        return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
    }

    public function autoCancel($id)
    {
        $sewa = SewaAlat::find($id);

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
