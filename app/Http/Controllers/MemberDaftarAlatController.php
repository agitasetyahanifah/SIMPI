<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlatPancing;

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
