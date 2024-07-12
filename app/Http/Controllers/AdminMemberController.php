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
        // Mengambil data pengguna dengan peran 'member', diurutkan berdasarkan tanggal pembuatan terbaru, dengan paginasi 25 item per halaman
        $members = User::where('role', 'member')->latest()->paginate(25);
        // Mendapatkan item terakhir dari koleksi data yang dipaginasi
        $lastItem = $members->lastItem();
        // Mengembalikan view 'Admin.ManajemenMember.index' dengan data 'members' dan 'lastItem'
        return view('Admin.ManajemenMember.index', compact('members','lastItem'));
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
        return redirect()->back()->with('success', 'Member data added successfully');
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
        // Validasi input form untuk nama, telepon, email, password opsional, dan status
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'status' => 'required|string|in:aktif,tidak aktif',
        ]);
    
        // Temukan data member berdasarkan ID
        $member = User::findOrFail($id);
    
        // Simpan data saat ini untuk membandingkan perubahan
        $currentData = [
            'nama' => $member->nama,
            'telepon' => $member->telepon,
            'email' => $member->email,
            'status' => $member->status,
        ];
    
        // Update data member dengan nilai dari form
        $member->nama = $request->input('nama');
        $member->telepon = $request->input('telepon');
        $member->email = $request->input('email');
    
        // Update password jika ada input password baru
        if ($request->filled('password')) {
            $member->password = bcrypt($request->input('password'));
        }
    
        // Update status member
        $member->status = $request->input('status');
    
        // Periksa apakah ada perubahan pada data
        $isUpdated = $member->isDirty();
    
        // Jika tidak ada perubahan, kembalikan dengan pesan info
        if (!$isUpdated) {
            return redirect()->back()->with('info', 'No changes were made to the member data.');
        }
    
        // Simpan perubahan data member
        $member->save();
    
        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Member data has been updated successfully');
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
        return redirect()->back()->with('success', 'Member data has been successfully deleted.');
    }
}
