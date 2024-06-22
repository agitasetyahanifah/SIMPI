<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use App\Models\SewaSpot;
use App\Models\User;
use App\Models\Spot;

class AdminSewaPemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sewaPemancingan = SewaSpot::with(['member', 'spot'])
                            ->orderBy('tanggal_sewa', 'desc')
                            ->orderBy('updated_at', 'desc')
                            ->paginate(25);
        $lastItem = $sewaPemancingan->lastItem();
        $spots = Spot::all();
        $jsonSpots = $spots->toJson();
      
        return view('admin.sewapemancingan.index', compact('sewaPemancingan', 'lastItem', 'spots', 'jsonSpots'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        // Query untuk mencari data berdasarkan keyword
        $sewaPemancingan = Sewaspot::where('kode_booking', 'like', "%$keyword%")
            ->whereHas('member', function ($query) use ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                    ->where('role', 'member');
            })
            ->orWhereHas('member', function ($query) use ($keyword) {
                $query->where('role', 'member');
            })
            ->get();
            
        // Kirim data pencarian ke view
        return view('admin.sewapemancingan.index', compact('sewaPemancingan'));
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
            return redirect()->back()->with('error', 'Spot ini sudah dipesan pada tanggal dan sesi yang sama. Silakan pilih spot lain.');
        }
    
        // Validasi apakah nomor spot tersebut sudah dipesan pada tanggal dan sesi yang sama
        $existingSpotOrder = SewaSpot::where('tanggal_sewa', $request->edit_tanggal_sewa)
                                      ->where('spot_id', $request->edit_nomor_spot)
                                      ->where('sesi', $request->edit_sesi)
                                      ->where('id', '!=', $id) // Exclude the current spot ID
                                      ->exists();
    
        if ($existingSpotOrder) {
            return redirect()->back()->with('error', 'Nomor spot ini sudah dipesan pada tanggal dan sesi yang sama. Silakan pilih spot lain.');
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
    
            $message = 'Sewa spot pemancingan berhasil diupdate dengan perubahan.';
        } else {
            $message = 'Tidak ada perubahan pada sewa spot pemancingan.';
        }
    
        return redirect()->back()->with('success', $message);
    }       
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sewaPemancingan = SewaSpot::findOrFail($id);
            
        // Hapus alat pancing dari database
        $sewaPemancingan->delete();
            
        // Redirect kembali ke halaman sewa pemancingan dengan pesan sukses
        return redirect()->back()->with('success', 'Data penyewaan pemancingan berhasil dihapus.');
    }

    public function konfirmasiPembayaran($id, Request $request)
    {
        $pemancingan = SewaSpot::findOrFail($id);

        // Periksa apakah status sudah 'sudah dibayar'
        if ($pemancingan->status === 'sudah dibayar') {
            return redirect()->back()->with('error', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }

        // Perbarui status pembayaran
        $pemancingan->status = $request->status;
        $pemancingan->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
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
