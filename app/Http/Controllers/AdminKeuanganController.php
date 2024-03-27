<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class AdminKeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::orderBy('tanggal_transaksi', 'desc')->paginate(25);
        $lastItem = $keuangans->lastItem();
        return view('admin.keuangan.index', compact('keuangans', 'lastItem'));
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

        // Simpan data ke database
        Keuangan::create($validatedData);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Mengambil data transaksi keuangan berdasarkan ID
        $keuangan = Keuangan::findOrFail($id);
        
        // Mengembalikan view edit dengan data transaksi yang dipilih
        return view('Admin.Keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir edit
        $request->validate([
            'edit_tanggal_transaksi' => 'required|date',
            'edit_jumlah' => 'required|numeric',
            'edit_jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'edit_keterangan' => 'nullable|string|max:255',
        ]);

        // Mengambil data transaksi keuangan berdasarkan ID
        $keuangan = Keuangan::findOrFail($id);

        // Mengupdate data transaksi keuangan dengan data baru dari formulir edit
        $keuangan->tanggal_transaksi = $request->edit_tanggal_transaksi;
        $keuangan->jumlah = $request->edit_jumlah;
        $keuangan->jenis_transaksi = $request->edit_jenis_transaksi;
        $keuangan->keterangan = $request->edit_keterangan;
        $keuangan->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

}
