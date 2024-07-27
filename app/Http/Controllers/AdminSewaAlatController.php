<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\AlatPancing;
use App\Models\SewaAlat;
use App\Models\User;
use App\Models\Keuangan;
use Carbon\Carbon;

class AdminSewaAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data sewa alat pancing dengan relasi 'member' dan 'alatPancing', 
        // diurutkan berdasarkan tanggal pinjam dan tanggal update secara menurun, dengan paginasi 25 item per halaman
        $sewaAlat = SewaAlat::with(['member', 'alatPancing'])->orderBy('tgl_pinjam', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
        // Mendapatkan item terakhir dari koleksi data yang dipaginasi
        $lastItem = $sewaAlat->lastItem();
        // Mengambil semua data pengguna dengan role 'member'
        $member = User::where('role', 'member')->get();
        // Mengambil semua data pengguna dengan role 'member' dan diurutkan berdasarkan nama secara ascending
        $members = User::where('role', 'member')->orderBy('nama', 'asc')->get();        
        // Mengambil semua data alat pancing
        $alatPancing = AlatPancing::all();
        // Mengambil semua data alat pancing dengan status 'available'
        $alatPancings = AlatPancing::where('status', 'available')->get();
        // Mengembalikan view 'Admin.SewaAlat.index' dengan data 'sewaAlat', 'lastItem', 'member', 'members', 'alatPancing', dan 'alatPancings'
        return view('Admin.SewaAlat.index', compact('sewaAlat', 'lastItem', 'member', 'members', 'alatPancing', 'alatPancings'));
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
    
        foreach ($request->nama_alat as $alatId) {
            $sewaAlat->alatPancing()->attach($alatId);
        }
    
        // Hitung biaya sewa
        $biaya_sewa = $this->hitungBiayaSewa($sewaAlat->tgl_pinjam, $sewaAlat->tgl_kembali, $request->nama_alat);
    
        // Simpan biaya sewa ke dalam data sewa alat
        $sewaAlat->biaya_sewa = $biaya_sewa;
        $sewaAlat->save();
    
        // Redirect atau kirim respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Fishing equipment rental data has been successfully added.');
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
        // Validasi data yang dikirim dari form
        $request->validate([
            'edit_alat' => 'required',
            'edit_jumlah' => 'required|numeric|min:1',
            'edit_tgl_pinjam' => 'required|date',
            'edit_tgl_kembali' => 'required|date|after_or_equal:edit_tgl_pinjam',
        ]);
    
        // Cari data sewa alat berdasarkan ID
        $sewaAlat = SewaAlat::findOrFail($id);
    
        // Ambil data alat pancing sebelumnya yang terkait dengan sewa ini
        $alatPancingSebelumnya = $sewaAlat->alatPancing;
    
        // Simpan data stok alat sebelumnya
        $jumlahSebelumnya = $sewaAlat->jumlah;
    
        // Perbarui data sewa alat
        $sewaAlat->tgl_pinjam = $request->edit_tgl_pinjam;
        $sewaAlat->tgl_kembali = $request->edit_tgl_kembali;
        $sewaAlat->jumlah = $request->edit_jumlah;
    
        // Cari data alat pancing berdasarkan ID
        $alatPancing = AlatPancing::findOrFail($request->edit_alat);
    
        // Kembalikan stok alat yang tidak jadi dipilih ke stok awal
        if ($alatPancingSebelumnya->id !== $alatPancing->id) {
            $alatPancingSebelumnya->jumlah += $jumlahSebelumnya;
            $alatPancingSebelumnya->save();
        } else {
            // Jika alat yang dipilih tetap sama, tambahkan kembali jumlah yang dipinjam sebelumnya sebelum pengurangan baru
            $alatPancing->jumlah += $jumlahSebelumnya;
        }
    
        // Kurangi stok alat yang baru dipilih sesuai dengan jumlah yang baru
        $alatPancing->jumlah -= $request->edit_jumlah;
    
        // Simpan relasi antara sewa alat dan alat pancing
        $sewaAlat->alatPancing()->associate($alatPancing);
        $sewaAlat->save();
        $alatPancing->save();
    
        return redirect()->back()->with('success', 'Fishing equipment rental data has been successfully updated.');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sewaAlat = SewaAlat::findOrFail($id);
    
        // Hapus transaksi keuangan terkait sewa alat ini
        Keuangan::where('sewa_alat_id', $sewaAlat->id)->delete();
    
        // Hapus alat pancing dari database
        $sewaAlat->delete();
    
        // Redirect kembali ke halaman sewa pemancingan dengan pesan sukses
        return redirect()->back()->with('success', 'Fishing equipment rental data and associated financial records have been successfully deleted.');
    }       

    public function konfirmasiPembayaran($id, Request $request)
    {
        $alat = SewaAlat::findOrFail($id);
    
        // Periksa apakah status sudah 'sudah dibayar'
        if ($alat->status === 'sudah dibayar') {
            return redirect()->back()->with('error', 'Payment has been confirmed beforehand.');
        }
    
        // Perbarui status pembayaran
        $alat->status = $request->status;
        $alat->save();
    
        // Simpan informasi transaksi keuangan
        $keuangan = new Keuangan();
        $keuangan->kode_transaksi = 'TRSA' . strtoupper(Str::random(10));
        $keuangan->user_id = Auth::id();
        $keuangan->sewa_alat_id = $alat->id;
        $keuangan->tanggal_transaksi = Carbon::now()->toDateString();
        $keuangan->waktu_transaksi = Carbon::now()->toTimeString();
        $keuangan->jumlah = $alat->biaya_sewa;
        $keuangan->jenis_transaksi = 'pemasukan';
        $keuangan->keterangan = 'Equipment Rental Payment by ' . $alat->member->nama;
        $keuangan->save();
    
        return redirect()->back()->with('success', 'Payment confirmed successfully.');
    }

    public function konfirmasiPengembalian($id, Request $request)
    {
        $sewaAlat = SewaAlat::findOrFail($id);
        $status_pengembalian = $request->input('status_pengembalian', 'sudah kembali');
    
        // Periksa apakah status pengembalian berubah menjadi 'sudah kembali'
        if ($status_pengembalian === 'sudah kembali' && $sewaAlat->status_pengembalian !== 'sudah kembali') {
            // Ambil jumlah alat pancing yang dikembalikan
            $jumlah_dikembalikan = $sewaAlat->jumlah;
            // Ambil alat pancing yang dipinjam pada sewa ini
            $alatPancing = $sewaAlat->alatPancing;
            // Perbarui jumlah stok alat pancing yang dikembalikan
            $alatPancing->jumlah += $jumlah_dikembalikan;
            $alatPancing->save();
        }
    
        $sewaAlat->status_pengembalian = $status_pengembalian;
        $sewaAlat->save();

        // Ambil denda dari tabel sewa_alat kolom denda
        $denda = $sewaAlat->denda;

        // Jika ada denda, masukkan denda ke dalam tabel keuangan
        if ($denda > 0) {
            $keuanganDenda = new Keuangan();
            $keuanganDenda->kode_transaksi = 'TRSA' . strtoupper(Str::random(10));
            $keuanganDenda->user_id = Auth::id();
            $keuanganDenda->sewa_alat_id = $sewaAlat->id;
            $keuanganDenda->tanggal_transaksi = Carbon::now()->toDateString();
            $keuanganDenda->waktu_transaksi = Carbon::now()->toTimeString();
            $keuanganDenda->jumlah = $denda;
            $keuanganDenda->jenis_transaksi = 'pemasukan';
            $keuanganDenda->keterangan = 'Fines for Late Return of Equipment by ' . $sewaAlat->member->nama;
            $keuanganDenda->save();
        }
    
        return redirect()->back()->with('success', 'The return status has been updated.');
    }    
    
}
