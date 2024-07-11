<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\SewaSpot;
use App\Models\User;
use App\Models\Spot;
use App\Models\Keuangan;
use Carbon\Carbon;

class AdminSewaPemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     // Mengambil data sewa spot pemancingan dengan relasi 'member' dan 'spot', 
    //     // diurutkan berdasarkan tanggal sewa dan tanggal update secara menurun, dengan paginasi 25 item per halaman
    //     $sewaPemancingan = SewaSpot::with(['member', 'spot'])
    //                         ->orderBy('tanggal_sewa', 'desc')
    //                         ->orderBy('updated_at', 'desc')
    //                         ->paginate(25);
    //     // Mendapatkan item terakhir dari koleksi data yang dipaginasi
    //     $lastItem = $sewaPemancingan->lastItem();
    //     // Mengambil semua data spot
    //     $spots = Spot::all();
    //     // Mengubah data spot menjadi format JSON
    //     $jsonSpots = $spots->toJson();

    //     // Mengembalikan view 'admin.sewapemancingan.index' dengan data 'sewaPemancingan', 'lastItem', 'spots', dan 'jsonSpots'    
    //     return view('admin.sewapemancingan.index', compact('sewaPemancingan', 'lastItem', 'spots', 'jsonSpots'));
    // }

    public function index(Request $request)
    {
        $search = $request->query('search'); // Ambil nilai pencarian dari query parameter 'search'

        // Query untuk mendapatkan data SewaSpot dengan relasi member dan spot
        $query = SewaSpot::with(['member', 'spot'])
                        ->orderBy('tanggal_sewa', 'desc')
                        ->orderBy('updated_at', 'desc');

        // Jika ada pencarian, filter berdasarkan nama member atau nama spot atau tanggal sewa atau status
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                })->orWhereHas('spot', function ($query) use ($search) {
                    $query->where('nama_spot', 'like', '%' . $search . '%');
                })->orWhere('tanggal_sewa', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        // Paginasi dengan 25 item per halaman
        $sewaPemancingan = $query->paginate(25);
        $lastItem = $sewaPemancingan->lastItem(); // Item terakhir dari data yang dipaginasi

        // Mengambil semua data spot
        $spots = Spot::all();
        // Mengubah data spot menjadi format JSON
        $jsonSpots = $spots->toJson();

        // Mengembalikan view 'admin.sewapemancingan.index' dengan data 'sewaPemancingan', 'lastItem'
        return view('admin.sewapemancingan.index', compact('sewaPemancingan', 'lastItem', 'search', 'spots','jsonSpots'));
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_tanggal_sewa' => 'required|date',
            'edit_nomor_spot' => 'required|exists:spots,id',
            'edit_sesi' => 'required|in:08.00-12.00,13.00-17.00',
        ]);
    
        // Validasi apakah sudah ada pesanan sewa yang sama setelah diupdate
        $existingOrder = SewaSpot::where('tanggal_sewa', $request->edit_tanggal_sewa)
                                  ->where('spot_id', $request->edit_nomor_spot)
                                  ->where('sesi', $request->edit_sesi)
                                  ->where('id', '!=', $id)
                                  ->exists();
    
        if ($existingOrder) {
            return redirect()->back()->with('error', 'This spot is booked for the same date and session. Please choose another spot!');
        }
    
        // Validasi apakah nomor spot tersebut sudah dipesan pada tanggal dan sesi yang sama
        $existingSpotOrder = SewaSpot::where('tanggal_sewa', $request->edit_tanggal_sewa)
                                      ->where('spot_id', $request->edit_nomor_spot)
                                      ->where('sesi', $request->edit_sesi)
                                      ->where('id', '!=', $id) // Exclude the current spot ID
                                      ->exists();
    
        if ($existingSpotOrder) {
            return redirect()->back()->with('error', 'This spot is booked for the same date and session. Please choose another spot!');
        }
    
        // Proses update jika validasi berhasil
        $pemancingan = SewaSpot::findOrFail($id);
    
        if ($pemancingan->tanggal_sewa != $request->edit_tanggal_sewa ||
            $pemancingan->spot_id != $request->edit_nomor_spot ||
            $pemancingan->sesi != $request->edit_sesi) {
            $pemancingan->tanggal_sewa = $request->edit_tanggal_sewa;
            $pemancingan->spot_id = $request->edit_nomor_spot;
            $pemancingan->sesi = $request->edit_sesi;
            $pemancingan->status = 'menunggu pembayaran';
            $pemancingan->save();
    
            $message = 'Fishing spot reservation successfully updated with changes.';
        } else {
            $message = 'There are no changes to fishing spot reservations.';
        }
    
        return redirect()->back()->with('success', $message);
    }       
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sewaPemancingan = SewaSpot::findOrFail($id);
    
        // Hapus transaksi keuangan terkait sewa spot ini
        Keuangan::where('keterangan', 'like', '%Spot Booking Payment by ' . $sewaPemancingan->member->nama . '%')
            ->delete();
    
        // Hapus sewa spot dari database
        $sewaPemancingan->delete();
    
        // Redirect kembali ke halaman sewa pemancingan dengan pesan sukses
        return redirect()->back()->with('success', 'Fishing spot reservation data and associated financial records have been successfully deleted.');
    }    

    public function konfirmasiPembayaran($id, Request $request)
    {
        $pemancingan = SewaSpot::findOrFail($id);

        // Periksa apakah status sudah 'sudah dibayar'
        if ($pemancingan->status === 'sudah dibayar') {
            return redirect()->back()->with('error', 'Payment has been confirmed beforehand.');
        }

        // Perbarui status pembayaran
        $pemancingan->status = $request->status;
        $pemancingan->save();

        // Simpan informasi transaksi keuangan
        $keuangan = new Keuangan();
        $keuangan->kode_transaksi = 'TRSS' . strtoupper(Str::random(10));
        $keuangan->user_id = Auth::id();
        $keuangan->tanggal_transaksi = Carbon::now()->toDateString();
        $keuangan->waktu_transaksi = Carbon::now()->toTimeString();
        $keuangan->jumlah = $pemancingan->biaya_sewa;
        $keuangan->jenis_transaksi = 'pemasukan';
        $keuangan->keterangan = 'Spot Booking Payment by ' . $pemancingan->member->nama;
        $keuangan->save();

        return redirect()->back()->with('success', 'Payment confirmed successfully.');
    }

    public function getAvailableSpotsJson(Request $request)
    {
        $tanggalSewa = $request->input('tanggal_sewa');
        $sesi = $request->input('sesi');
        $currentSpotId = $request->input('current_spot_id');
        $currentSesi = $request->input('current_sesi');
        
        // Ambil semua nomor spot yang belum dipesan pada tanggal dan sesi tertentu
        $availableSpots = Spot::whereDoesntHave('sewaSpots', function ($query) use ($tanggalSewa, $sesi, $currentSpotId) {
            $query->where('tanggal_sewa', $tanggalSewa)
                  ->where('sesi', $sesi)
                  ->when($currentSpotId, function($q) use ($currentSpotId) {
                      // Kecualikan spot yang saat ini dipilih oleh pengguna
                      $q->where('spot_id', '!=', $currentSpotId);
                  });
        })->get();
        
        // Tambahkan spot yang saat ini sedang dipilih jika ada
        if ($currentSpotId) {
            $currentSpot = Spot::find($currentSpotId);
            if ($currentSpot) {
                $availableSessions = $currentSpot->getAvailableSessions($tanggalSewa, $currentSesi);
                if (in_array($sesi, $availableSessions)) {
                    $availableSpots->push($currentSpot);
                }
            }
        }
        
        return response()->json(['jsonSpots' => $availableSpots]);
    }        

}
