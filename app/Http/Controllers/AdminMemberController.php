<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = User::where('role', 'member')->latest()->paginate(25);
        $lastItem = $members->lastItem();
        return view('admin.manajemenmember.index', compact('members','lastItem'));
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
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:user,email',
            'password' => 'required|string|min:8',
            'status' => 'required|string|in:aktif,tidak aktif',
        ]);

        // Membuat member baru
        $member = new User;
        $member->nama = $request->input('nama');
        $member->telepon = $request->input('telepon');
        $member->email = $request->input('email');
        $member->password = bcrypt($request->input('password'));
        $member->status = $request->input('status');

        // Menyimpan member baru
        $member->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data member berhasil ditambahkan');
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
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'status' => 'required|string|in:aktif,tidak aktif',
        ]);

        // Find the member by ID
        $member = User::findOrFail($id);

        // Update member data
        $member->nama = $request->input('nama');
        $member->telepon = $request->input('telepon');
        $member->email = $request->input('email');

        // Update password only if provided
        if ($request->filled('password')) {
            $member->password = bcrypt($request->input('password'));
        }

        $member->status = $request->input('status');

        // Save the changes
        $member->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data member berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $members = User::findOrFail($id);
            
        // Hapus alat pancing dari database
        $members->delete();
            
        // Redirect kembali ke halaman manajemen member dengan pesan sukses
        return redirect()->back()->with('success', 'Data member berhasil dihapus.');
    }
}
