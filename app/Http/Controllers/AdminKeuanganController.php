<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use Illuminate\Support\Str;

class AdminKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil nilai bulan dan tahun dari request
        $month = $request->input('month');
        $year = $request->input('year');
    
        // Membuat query dasar
        $query = Keuangan::orderBy('tanggal_transaksi', 'desc')->orderBy('updated_at', 'desc');
    
        // Menambahkan kondisi filter jika bulan dan tahun dipilih
        if ($month) {
            $query->whereMonth('tanggal_transaksi', $month);
        }
    
        if ($year) {
            $query->whereYear('tanggal_transaksi', $year);
        }
    
        // Mengambil data transaksi keuangan dengan paginasi 25 item per halaman
        $mutasiTransaksi = $query->paginate(25);
        $keuangans = $query->paginate(25);
        $lastItem = $keuangans->lastItem();
    
        // Mengembalikan view 'admin.keuangan.index' dengan data 'keuangans', 'lastItem', dan 'mutasiTransaksi'
        return view('admin.keuangan.index', compact('keuangans', 'lastItem', 'mutasiTransaksi'));
    }
    
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jumlah' => 'required|numeric',
            'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'nullable|string|max:255',
        ]);
    
        // Generate kode transaksi dengan awalan khusus
        $prefix = $request->jenis_transaksi === 'pemasukan' ? 'IN' : 'OUT';
        $kodeTransaksi = $prefix . strtoupper(Str::random(10));
    
        // Ambil user_id
        $userId = auth()->user()->id;
    
        // Buat instance baru dari model Keuangan
        $keuangan = new Keuangan();
        $keuangan->kode_transaksi = $kodeTransaksi;
        $keuangan->user_id = $userId;
        $keuangan->tanggal_transaksi = $request->input('tanggal_transaksi');
        $keuangan->waktu_transaksi = now()->format('H:i:s');
        $keuangan->jumlah = $request->input('jumlah');
        $keuangan->jenis_transaksi = $request->input('jenis_transaksi');
        $keuangan->keterangan = $request->input('keterangan');
    
        // Simpan data ke database
        $keuangan->save();
    
        // Redirect atau response sesuai kebutuhan
        return redirect()->route('admin.keuangan.index')->with('success', 'Transaction added successfully!');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Mengambil data transaksi keuangan berdasarkan ID
        $keuangan = Keuangan::findOrFail($id);
    
        // Simpan data saat ini untuk membandingkan perubahan
        $currentData = [
            'tanggal_transaksi' => $keuangan->tanggal_transaksi,
            'jumlah' => $keuangan->jumlah,
            'jenis_transaksi' => $keuangan->jenis_transaksi,
            'keterangan' => $keuangan->keterangan,
        ];
    
        // Validasi input form untuk tanggal transaksi, jumlah, jenis transaksi, dan keterangan
        $validated = $request->validate([
            'edit_tanggal_transaksi' => 'required|date',
            'edit_jumlah' => 'required|numeric',
            'edit_jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'edit_keterangan' => 'nullable|string|max:255',
        ]);
    
        // Update data transaksi keuangan jika ada perubahan
        if ($keuangan->tanggal_transaksi != $validated['edit_tanggal_transaksi'] ||
            $keuangan->jumlah != $validated['edit_jumlah'] ||
            $keuangan->jenis_transaksi != $validated['edit_jenis_transaksi'] ||
            $keuangan->keterangan != $validated['edit_keterangan']) {
            
            $keuangan->tanggal_transaksi = $validated['edit_tanggal_transaksi'];
            $keuangan->jumlah = $validated['edit_jumlah'];
            $keuangan->jenis_transaksi = $validated['edit_jenis_transaksi'];
            $keuangan->keterangan = $validated['edit_keterangan'];
            $keuangan->save();
    
            // Redirect kembali ke halaman index dengan pesan sukses
            return redirect()->route('admin.keuangan.index')->with('success', 'Transaction updated successfully.');
        }
    
        // Jika tidak ada perubahan, kembalikan dengan pesan info
        return redirect()->back()->with('info', 'No changes were made to the transaction data.');
    }
            

    public function destroy($id)
    {
        // Mencari data keuangan berdasarkan ID, jika tidak ditemukan akan menampilkan error 404
        $keuangan = Keuangan::findOrFail($id);
        // Menghapus data keuangan yang ditemukan
        $keuangan->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Transaction successfully deleted.');
    }

    public function hitungSaldo()
    {
        $totalPemasukan = Keuangan::where('jenis_transaksi', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Keuangan::where('jenis_transaksi', 'pengeluaran')->sum('jumlah');
        
        $saldo = $totalPemasukan - $totalPengeluaran;
        return $saldo;
    }
    

}

