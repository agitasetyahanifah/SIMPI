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
        // Validate date
        $validatedData = $request->validate([
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'jumlah' => 'required|integer|min:1',
        ]);

        // hitung selisih hari
        $tglPinjam = new \DateTime($validatedData['tgl_pinjam']);
        $tglKembali = new \DateTime($validatedData['tgl_kembali']);
        $rentalDays = $tglPinjam->diff($tglKembali)->days;

        // cek jika hari pinjam dan kembali sama
        if ($rentalDays === 0) {
            $rentalDays = 1;
        }

        // ambil biaya sewa dan jumlah
        $alatPancing = AlatPancing::findOrFail($request->input('alat_id'));
        $hargaSewa = $alatPancing->harga;
        $jumlah = $validatedData['jumlah'];

        if ($jumlah > $alatPancing->jumlah) {
            return redirect()->back()->with('error', 'Jumlah alat pancing yang tersedia tidak mencukupi.');
        }

        // hitung total biaya dengan rumus
        $biayaSewa = $hargaSewa * $rentalDays * $jumlah;

        // buat sewa
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

        // Kurangi jumlah alat pancing yang tersedia
        $alatPancing->jumlah -= $jumlah;
        if ($alatPancing->jumlah <= 0) {
            $alatPancing->status = 'not available';
        }
        $alatPancing->save();

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

            // Kembalikan jumlah alat pancing yang dibatalkan ke database
            $alatPancing = AlatPancing::findOrFail($sewaAlat->alat_id);
            $alatPancing->jumlah += $sewaAlat->jumlah;

            if ($alatPancing->jumlah > 0) {
                $alatPancing->status = 'available';
            }

            $alatPancing->save();
    
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
    
                // Kembalikan jumlah alat pancing yang dibatalkan ke database
                $alatPancing = AlatPancing::findOrFail($sewa->alat_id);
                $alatPancing->jumlah += $sewa->jumlah;
    
                if ($alatPancing->jumlah > 0) {
                    $alatPancing->status = 'available';
                }
    
                $alatPancing->save();
            }
        }
    
        return response()->json(['success' => true]);
    }    

    public function markAsReturned($id)
    {
        $sewa = SewaAlat::findOrFail($id);
    
        if ($sewa->status !== 'sudah kembali') {
            $alatPancing = AlatPancing::findOrFail($sewa->alat_id);
            $alatPancing->jumlah += $sewa->jumlah;
    
            if ($alatPancing->jumlah > 0) {
                $alatPancing->status = 'available';
            }
    
            $alatPancing->save();
    
            $sewa->status_pengembalian = 'sudah kembali';
            $sewa->returned_at = now();
            $sewa->save();
    
            return redirect()->back()->with('success', 'Status pengembalian berhasil diubah dan jumlah alat diperbarui.');
        }
    
        return redirect()->back()->with('error', 'Alat ini sudah ditandai sebagai kembali.');
    }
    
}
