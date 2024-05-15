<?php

namespace App\Http\Controllers;

use App\Models\AlatPancing;
use App\Models\SewaAlat;
use App\Models\Member;
use Illuminate\Http\Request;

class AdminSewaAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sewaAlat = SewaAlat::with(['member', 'alat'])->orderBy('tgl_pinjam', 'desc')->paginate(25);
        $lastItem = $sewaAlat->lastItem();
        $member = Member::all();
        $alatPancing = AlatPancing::all();
        return view('admin.sewaalat.index', compact('sewaAlat', 'lastItem', 'member', 'alatPancing'));
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
        //
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
    public function update(Request $request, SewaAlat $sewaAlat)
    {
        //
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
