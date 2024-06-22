<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenyewaanAlat;
use App\Models\AlatPancing;
use App\Models\AlatPancingPenyewaanAlat;
use Illuminate\Support\Facades\DB;

class AdminPenyewaanAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alatPancing = AlatPancing::all();
        $penyewaanAlat = PenyewaanAlat::orderBy('created_at', 'desc')->paginate(25);
        $lastItem = $penyewaanAlat->lastItem();
        return view('admin.penyewaanalat.index', compact('penyewaanAlat', 'alatPancing','lastItem'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $penyewaanAlat = PenyewaanAlat::findOrFail($id);
            
        // Hapus alat pancing dari database
        $penyewaanAlat->delete();
            
        // Redirect kembali ke halaman daftar penyewaan alat dengan pesan sukses
        return redirect()->back()->with('success', 'Data penyewaan alat berhasil dihapus.');
    }  
}
