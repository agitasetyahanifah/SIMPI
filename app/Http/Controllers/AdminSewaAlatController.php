<?php

namespace App\Http\Controllers;

use App\Models\AlatPancing;
use App\Models\AlatSewa;
use App\Models\SewaAlat;
use App\Models\User;
use App\Models\SewaPemancingan;
use Illuminate\Http\Request;

class AdminSewaAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sewaAlat = SewaAlat::with(['member', 'alatPancing'])->orderBy('tgl_pinjam', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
        $lastItem = $sewaAlat->lastItem();
        $member = User::where('role', 'member')->get();
        $members = User::where('role', 'member')->orderBy('nama', 'asc')->get();        
        $alatPancing = AlatPancing::all();
        $alatPancings = AlatPancing::where('status', 'available')->get();
        // $alatSewa = AlatSewa::all();
        return view('admin.sewaalat.index', compact('sewaAlat', 'lastItem', 'member', 'members', 'alatPancing', 'alatPancings'));
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
        // Validasi data yang dikirim dari form
        $request->validate([
            'nama_pelanggan' => 'required',
            'nama_alat' => 'required|array',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);
    
        // Proses penyimpanan data ke dalam database sesuai dengan model masing-masing
        $sewaAlat = new SewaAlat();
        $sewaAlat->user_id = $request->nama_pelanggan;
        $sewaAlat->tgl_pinjam = $request->tgl_pinjam;
        $sewaAlat->tgl_kembali = $request->tgl_kembali;
        $sewaAlat->save();
    
        // Attach selected fishing equipment to the SewaAlat model
        // $sewaAlat->alatPancing()->attach($request->nama_alat);
        foreach ($request->nama_alat as $alatId) {
            $sewaAlat->alatPancing()->attach($alatId);
        }
    
        // Hitung biaya sewa
        $biaya_sewa = $this->hitungBiayaSewa($sewaAlat->tgl_pinjam, $sewaAlat->tgl_kembali, $request->nama_alat);
    
        // Simpan biaya sewa ke dalam data sewa alat
        $sewaAlat->biaya_sewa = $biaya_sewa;
        $sewaAlat->save();
    
        // Redirect atau kirim respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Data sewa alat pancing berhasil ditambahkan.');
    }
    
    private function hitungBiayaSewa($tgl_pinjam, $tgl_kembali, $nama_alat)
    {
        // Hitung selisih hari antara tanggal kembali dan tanggal pinjam
        $diff = strtotime($tgl_kembali) - strtotime($tgl_pinjam);
        $selisih_hari = round($diff / (60 * 60 * 24)); // Konversi detik ke hari
    
        // Ambil harga alat pancing berdasarkan nama alat yang dipilih
        $harga_total = 0;
        foreach ($nama_alat as $nama) {
            $harga_alat = AlatPancing::where('nama_alat', $nama)->value('harga');
            $harga_total += $harga_alat;
        }
    
        // Hitung biaya sewa berdasarkan harga total alat dikali selisih hari
        $biaya_sewa = $harga_total * $selisih_hari;
    
        return $biaya_sewa;
    }
    

    /**
     * Display the specified resource.
     */
    public function show(SewaAlat $sewaAlat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SewaAlat $sewaAlat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_tgl_pinjam' => 'required|date',
            'edit_tgl_kembali' => 'required|date',
            'edit_alat_pancing' => 'required|array',
        ]);
    
        $sewaAlat = SewaAlat::findOrFail($id);
        $sewaAlat->tgl_pinjam = $request->edit_tgl_pinjam;
        $sewaAlat->tgl_kembali = $request->edit_tgl_kembali;
        $sewaAlat->save();
    
        // Sync alat pancing
        $sewaAlat->alatPancing()->sync($request->edit_alat_pancing);

        return redirect()->route('admin.sewaAlat.index')->with('success', 'Data penyewaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sewaAlat = SewaAlat::findOrFail($id);
            
        // Hapus alat pancing dari database
        $sewaAlat->delete();
            
        // Redirect kembali ke halaman sewa pemancingan dengan pesan sukses
        return redirect()->back()->with('success', 'Data penyewaan alat pancing berhasil dihapus.');
    }

    public function konfirmasiPembayaran($id, Request $request)
    {
        $alat = SewaAlat::findOrFail($id);

        // Periksa apakah status sudah 'sudah dibayar'
        if ($alat->status === 'sudah dibayar') {
            return redirect()->back()->with('error', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }

        // Perbarui status pembayaran
        $alat->status = $request->status;
        $alat->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}
