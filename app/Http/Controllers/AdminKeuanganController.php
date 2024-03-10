<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class AdminKeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::orderBy('created_at', 'desc')->paginate(30);
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
            'keterangan' => 'nullable|string',
        ]);

        // Simpan data ke database
        Keuangan::create($validatedData);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

}
