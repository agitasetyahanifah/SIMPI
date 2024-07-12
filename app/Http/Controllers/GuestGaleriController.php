<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;

class GuestGaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data gambar dari Galeri, diurutkan berdasarkan tanggal pembuatan terbaru, dengan paginasi 24 item per halaman
        $images = Galeri::orderBy('created_at', 'desc')->paginate(24);
        // Mendapatkan item terakhir dari koleksi data yang dipaginasi
        $lastItem = $images->lastItem();
        // Mengembalikan view 'guest.galeri.galeri' dengan data 'images' dan 'lastItem'
        return view('Guest.Galeri.galeri', compact('images', 'lastItem'));
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
}
