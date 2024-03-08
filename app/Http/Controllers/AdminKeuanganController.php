<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class AdminKeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::all();
        return view('admin.keuangan.index', compact('keuangans'));
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
}
