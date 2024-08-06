<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\SewaSpot;
use App\Models\User;
use App\Models\Spot;
use App\Models\Keuangan;
use Carbon\Carbon;
use App\Models\UpdateHargaSewaSpot;
use App\Models\UpdateSesiSewaSpot;
use App\Notifications\SesiSpotUpdated;

class AdminSewaPemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mendapatkan user_id dari auth jika user terautentikasi
        $userId = auth()->check() ? auth()->id() : null;

        // Mengambil data sewa spot pemancingan dengan relasi 'member' dan 'spot', 
        // diurutkan berdasarkan tanggal sewa dan tanggal update secara menurun, dengan paginasi 25 item per halaman
        $sewaPemancingan = SewaSpot::with(['member', 'spot'])
                            ->orderBy('tanggal_sewa', 'desc')
                            ->orderBy('updated_at', 'desc')
                            ->paginate(25);
        // Mendapatkan item terakhir dari koleksi data yang dipaginasi
        $lastItem = $sewaPemancingan->lastItem();
        // Mengambil semua data spot
        $spots = Spot::all();
        // Mengubah data spot menjadi format JSON
        $jsonSpots = $spots->toJson();

        // Mengambil harga member dan non-member terbaru
        $hargaMember = UpdateHargaSewaSpot::where('status_member', 'member')
                                        ->latest()
                                        ->first();

        $hargaNonMember = UpdateHargaSewaSpot::where('status_member', 'non member')
                                            ->latest()
                                            ->first();

        // Jika tidak ada harga yang ditemukan, set default value
        $hargaMember = $hargaMember ? $hargaMember->harga : 0;
        $hargaNonMember = $hargaNonMember ? $hargaNonMember->harga : 0;

        // Mengambil harga member terbaru
        $latestMemberPrice = UpdateHargaSewaSpot::where('status_member', 'member')->latest()->first();
        $memberPrice = $latestMemberPrice ? $latestMemberPrice->harga : 0;
        $harga_member_id = $latestMemberPrice ? $latestMemberPrice->id : null;

        // Mengambil harga non member terbaru
        $latestNonMemberPrice = UpdateHargaSewaSpot::where('status_member', 'non member')->latest()->first();
        $nonMemberPrice = $latestNonMemberPrice ? $latestNonMemberPrice->harga : 0;
        $harga_nonmember_id = $latestNonMemberPrice ? $latestNonMemberPrice->id : null;

        // Ambil sesi sewa spot
        $sesiSpot = UpdateSesiSewaSpot::latest()->get();

        // Mengambil data pengguna dengan role "member"
        $members = User::where('role', 'member')->where('status', 'aktif')->orderBy('nama', 'asc')->get();

        // Mengembalikan view 'Admin.SewaPemancingan.index' dengan data 'sewaPemancingan', 'lastItem', 'spots', dan 'jsonSpots'    
        return view('Admin.SewaPemancingan.index', compact('sewaPemancingan', 'lastItem', 'spots', 'jsonSpots', 'sesiSpot', 'hargaMember', 'hargaNonMember','members','memberPrice', 'harga_member_id','nonMemberPrice','harga_nonmember_id'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }     

    public function storeMemberReservation(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id|integer',
            'booking_date' => 'required|date|after_or_equal:today',
            'session_id' => 'required|exists:update_sesi_sewa_spots,id|integer',
            'spot_id' => 'required|exists:spots,id|integer',
            'price_id' => 'required|exists:update_harga_sewa_spots,id|integer',
        ]);
    
        // Ambil data dari hasil validasi
        $userId = $validated['customer_id'];
        $tanggalSewa = $validated['booking_date'];
        $sesiId = $validated['session_id'];
        $spotId = $validated['spot_id'];
        $hargaId = $validated['price_id'];
    
        // Simpan reservasi
        SewaSpot::create([
            'tipe_sewa' => 'member',
            'user_id' => $userId,
            'tanggal_sewa' => $tanggalSewa,
            'spot_id' => $spotId,
            'sesi_id' => $sesiId,
            'harga_id' => $hargaId,
            'status' => 'menunggu pembayaran',
        ]);
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Reservation spot for member created successfully.');
    }

    public function storeNonMemberReservation(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            // 'customer_name' => 'required|string',
            'booking_date' => 'required|date|after_or_equal:today',
            'session_id' => 'required|exists:update_sesi_sewa_spots,id|integer',
            'spot_id' => 'required|exists:spots,id|integer',
            'price_id' => 'required|exists:update_harga_sewa_spots,id|integer',
        ]);

        // Ambil data dari hasil validasi
        // $customerName = $validated['customer_name'];
        $tanggalSewa = $validated['booking_date'];
        $sesiId = $validated['session_id'];
        $spotId = $validated['spot_id'];
        $hargaId = $validated['price_id'];

        // Simpan reservasi
        SewaSpot::create([
            'tipe_sewa' => 'non member',
            'user_id' => null,
            'tanggal_sewa' => $tanggalSewa,
            'spot_id' => $spotId,
            'sesi_id' => $sesiId,
            'harga_id' => $hargaId,
            'status' => 'menunggu pembayaran',
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Reservation spot for non member created successfully.');
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
        // Validasi input dari form
        $request->validate([
            'edit_tanggal_sewa' => 'required|date',
            'edit_nomor_spot' => 'required|exists:spots,id',
            'edit_sesi' => 'required|exists:update_sesi_sewa_spots,id',
        ]);
    
        // Ambil sesi yang dipilih
        $selectedSesi = UpdateSesiSewaSpot::findOrFail($request->edit_sesi);
        
        // Ambil spot yang dipilih
        $selectedSpot = Spot::findOrFail($request->edit_nomor_spot);
    
        // Validasi apakah sudah ada pesanan sewa yang sama setelah diupdate
        $existingOrder = SewaSpot::where('tanggal_sewa', $request->edit_tanggal_sewa)
                                  ->where('spot_id', $request->edit_nomor_spot)
                                  ->where('sesi_id', $selectedSesi->id)
                                  ->where('id', '!=', $id)
                                  ->exists();
    
        if ($existingOrder) {
            return redirect()->back()->with('error', 'This spot is booked for the same date and session. Please choose another spot!');
        }
    
        // Proses update jika validasi berhasil
        $pemancingan = SewaSpot::findOrFail($id);
    
        if ($pemancingan->tanggal_sewa != $request->edit_tanggal_sewa ||
            $pemancingan->spot_id != $request->edit_nomor_spot ||
            $pemancingan->sesi_id != $selectedSesi->id) {
            $pemancingan->tanggal_sewa = $request->edit_tanggal_sewa;
            $pemancingan->spot_id = $request->edit_nomor_spot;
            $pemancingan->sesi_id = $selectedSesi->id;
    
            // Ambil harga ID sesuai dengan status member/non-member
            $user = $request->user(); // User yang sedang login
            $pemancinganStatus = $pemancingan->user_id ? 'member' : 'non member'; // Tentukan status berdasarkan user_id
    
            $pemancingan->harga_id = $this->getHargaIdForSpot($pemancinganStatus);
            // $pemancingan->status = 'menunggu pembayaran';
            $pemancingan->save();
    
            return redirect()->back()->with('success', 'Fishing spot reservation successfully updated with changes.');
        } else {
            return redirect()->back()->with('info', 'There are no changes to fishing spot reservations.');
        }
    }
    
    /**
     * Mendapatkan harga ID berdasarkan spot dan user
     */
    private function getHargaIdForSpot($status)
    {
        // Mendapatkan harga member dan non-member terbaru
        $harga = UpdateHargaSewaSpot::where('status_member', $status)->latest()->first();
        
        return $harga ? $harga->id : null;
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan data sewa spot berdasarkan ID
        $sewaPemancingan = SewaSpot::findOrFail($id);
    
        // Hapus transaksi keuangan terkait dengan ID sewa spot ini
        Keuangan::where('sewa_spot_id', $id)->delete();
    
        // Hapus data sewa spot dari database
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

        // Ambil harga berdasarkan harga_id yang terkait dengan pemesanan
        $harga = UpdateHargaSewaSpot::find($pemancingan->harga_id);
        $jumlah = $harga ? $harga->harga : 0;

        // Simpan informasi transaksi keuangan
        $keuangan = new Keuangan();
        $keuangan->kode_transaksi = 'TRSS' . strtoupper(Str::random(10));
        $keuangan->user_id = Auth::id();
        $keuangan->sewa_spot_id = $pemancingan->id;
        $keuangan->tanggal_transaksi = Carbon::now()->toDateString();
        $keuangan->waktu_transaksi = Carbon::now()->toTimeString();
        $keuangan->jumlah = $jumlah;
        $keuangan->jenis_transaksi = 'pemasukan';
        // $keuangan->keterangan = 'Spot Booking Payment by ' . $pemancingan->member->nama;
        $keuangan->keterangan = 'Spot Booking Payment by ' . ($pemancingan->user_id ? $pemancingan->member->nama : 'Non Member');
        $keuangan->save();

        return redirect()->back()->with('success', 'Payment confirmed successfully.');
    }

    public function konfirmasiKehadiran(Request $request, $id)
    {
        $sewaPemancingan = SewaSpot::findOrFail($id);
        $sewaPemancingan->status_kehadiran = 'sudah hadir';
        $sewaPemancingan->save();
    
        return redirect()->back()->with('success', 'Attendance status updated successfully.');
    }    

    public function getAvailableSpotsJson(Request $request)
    {
        $tanggalSewa = $request->input('tanggal_sewa');
        $sesiId = $request->input('sesi_id');
        $currentSpotId = $request->input('current_spot_id');
    
        $availableSpots = Spot::whereDoesntHave('sewaSpots', function ($query) use ($tanggalSewa, $sesiId, $currentSpotId) {
            $query->where('tanggal_sewa', $tanggalSewa)
                  ->where('sesi_id', $sesiId)
                  ->whereIn('status', ['sudah dibayar', 'menunggu pembayaran']);
        })->get();
    
        if ($currentSpotId) {
            $currentSpot = Spot::find($currentSpotId);
            if ($currentSpot) {
                $availableSessions = $currentSpot->getAvailableSessions($tanggalSewa);
                if (in_array($sesiId, $availableSessions)) {
                    $availableSpots->push($currentSpot);
                }
            }
        }
    
        return response()->json(['jsonSpots' => $availableSpots]);
    }           
    
    public function autoCancel($id)
    {
        // Temukan pesanan berdasarkan ID
        $sewa = SewaSpot::findOrFail($id);

        // Periksa apakah pesanan ditemukan dan statusnya masih 'menunggu pembayaran'
        if ($sewa && $sewa->status === 'menunggu pembayaran') {
            // Ambil waktu pembuatan pesanan dan waktu saat ini
            $createdTime = $sewa->created_at;
            $currentTime = now();

            // Hitung selisih dalam jam antara waktu pembuatan dan waktu saat ini
            $hoursDifference = $createdTime->diffInHours($currentTime);

            // Jika selisih lebih dari atau sama dengan 24 jam, batalkan pesanan
            if ($hoursDifference >= 24) {
                $sewa->status = 'dibatalkan';
                $sewa->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function updateHargaSpot(Request $request)
    {
        // Validasi data
        $request->validate([
            'price' => 'required|integer|min:0',
            'price_type' => 'required|in:member,non member',
        ]);
    
        // Simpan harga baru
        UpdateHargaSewaSpot::create([
            'harga' => $request->price,
            'user_id' => Auth::id(),
            'status_member' => $request->price_type
        ]);
    
        return redirect()->back()->with('success', 'Price updated successfully!');
    }    
    
    public function storeSesiSpot(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
    
        // Get the currently logged-in user ID
        $userId = Auth::id();
    
        // Check for duplicate session times
        $existingSession = UpdateSesiSewaSpot::where('waktu_mulai', $validatedData['start_time'])
            ->orWhere('waktu_selesai', $validatedData['end_time'])
            ->first();
    
        if ($existingSession) {
            return redirect()->back()->with('error', 'Session with the same time already exists.');
        }
    
        // Create a new session
        $sesiSpot = new UpdateSesiSewaSpot();
        $sesiSpot->waktu_mulai = $validatedData['start_time'];
        $sesiSpot->waktu_selesai = $validatedData['end_time'];
        $sesiSpot->waktu_sesi = $validatedData['start_time'] . ' - ' . $validatedData['end_time'];
        $sesiSpot->user_id = $userId; // Set the user_id
    
        // Save the session
        $sesiSpot->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Session added successfully!');
    }
    
    // public function updateSesiSpot(Request $request, $id)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //     ]);
    
    //     // Find the session by ID
    //     $session = UpdateSesiSewaSpot::findOrFail($id);
    
    //     // Check if there are any changes
    //     if (
    //         $session->waktu_mulai == $validatedData['start_time'] &&
    //         $session->waktu_selesai == $validatedData['end_time']
    //     ) {
    //         return redirect()->route('sewaPemancingan.index')->with('info', 'No changes were made.');
    //     }
    
    //     // Check for duplicate session times
    //     $existingSession = UpdateSesiSewaSpot::where('id', '!=', $id)
    //         ->where(function($query) use ($validatedData) {
    //             $query->where('waktu_mulai', $validatedData['start_time'])
    //                   ->orWhere('waktu_selesai', $validatedData['end_time']);
    //         })
    //         ->first();
    
    //     if ($existingSession) {
    //         return redirect()->route('sewaPemancingan.index')->with('error', 'Session with the same time already exists.');
    //     }
    
    //     // Update the session with new values
    //     $session->waktu_mulai = $validatedData['start_time'];
    //     $session->waktu_selesai = $validatedData['end_time'];
    //     $session->waktu_sesi = $validatedData['start_time'] . ' - ' . $validatedData['end_time'];
    //     $session->user_id = auth()->id();
    //     $session->save();
    
    //     return redirect()->route('sewaPemancingan.index')->with('success', 'Session updated successfully!');
    // }

    public function updateSesiSpot(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
    
        // Find the session by ID
        $session = UpdateSesiSewaSpot::findOrFail($id);
    
        // Check if there are any changes
        if (
            $session->waktu_mulai == $validatedData['start_time'] &&
            $session->waktu_selesai == $validatedData['end_time']
        ) {
            return redirect()->route('sewaPemancingan.index')->with('info', 'No changes were made.');
        }
    
        // Check for duplicate session times
        $existingSession = UpdateSesiSewaSpot::where('id', '!=', $id)
            ->where(function($query) use ($validatedData) {
                $query->where('waktu_mulai', $validatedData['start_time'])
                      ->orWhere('waktu_selesai', $validatedData['end_time']);
            })
            ->first();
    
        if ($existingSession) {
            return redirect()->route('sewaPemancingan.index')->with('error', 'Session with the same time already exists.');
        }

        // Find related SewaSpot
        $sewaSpots = SewaSpot::where('sesi_id', $id)->get();
    
        // Notifikasi ke member
        $membersToNotify = SewaSpot::where('sesi_id', $id)
            ->whereIn('status', ['sudah dibayar', 'menunggu pembayaran'])
            ->where('status_kehadiran', 'belum hadir')
            ->get();
    
        // Update sesi
        $session->waktu_mulai = $validatedData['start_time'];
        $session->waktu_selesai = $validatedData['end_time'];
        $session->waktu_sesi = $validatedData['start_time'] . ' - ' . $validatedData['end_time'];
        $session->user_id = auth()->id();
        $session->save();
    
        // Kirim notifikasi ke member
        if ($membersToNotify && $membersToNotify->isNotEmpty()) {
            foreach ($membersToNotify as $member) {
                // Check if $member and $member->user exist
                if (isset($member->user) && $member->user) {
                    Notification::send($member->user, new SesiSpotUpdated($session, $member));
                } else {
                    // Log a warning if $member or $member->user is missing
                    Log::warning('Cannot send notification, user is missing or $member is null.', ['member' => $member]);
                }
            }
        } else {
            Log::info('No members to notify.');
        }

        return redirect()->route('sewaPemancingan.index')->with('success', 'Session updated successfully!');
    }

    public function deleteSesiSpot($id)
    {
        // Find the session by ID
        $session = UpdateSesiSewaSpot::findOrFail($id);

        // Delete the session
        $session->delete();

        return redirect()->back()->with('success', 'Session deleted successfully!');
    }

}
