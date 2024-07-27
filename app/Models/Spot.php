<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    protected $table = 'spots';

    protected $guarded = ['id'];

    public function sewaSpots()
    {
        return $this->hasMany(SewaSpot::class);
    }

    // public function isBookedOnDate($tanggalSewa, $sesi)
    // {
    //     // Ambil semua sesi yang sudah dipesan pada tanggal sewa tertentu
    //     $bookedSessions = $this->sewaSpots()
    //                            ->where('tanggal_sewa', $tanggalSewa)
    //                            ->pluck('sesi')
    //                            ->toArray();
    
    //     // Cek apakah sesi yang ingin dicek termasuk dalam sesi yang sudah dipesan
    //     return in_array($sesi, $bookedSessions);
    // }  

    // public function getAvailableSessions($tanggalSewa, $currentSesi = null)
    // {
    //     // Dapatkan semua sesi yang sudah dipesan pada tanggal sewa tertentu
    //     $bookedSessions = $this->sewaSpots()
    //                            ->where('tanggal_sewa', $tanggalSewa)
    //                            ->pluck('sesi')
    //                            ->toArray();
        
    //     // Jika sesi saat ini dipilih oleh pengguna, hapus sesi tersebut dari bookedSessions
    //     if ($currentSesi) {
    //         $bookedSessions = array_diff($bookedSessions, [$currentSesi]);
    //     }
    
    //     $allSessions = ['08.00-12.00', '13.00-17.00']; // Sesuaikan dengan daftar semua sesi yang tersedia
        
    //     // Hitung perbedaan antara semua sesi dan sesi yang sudah dipesan
    //     $availableSessions = array_diff($allSessions, $bookedSessions);
        
    //     return $availableSessions;
    // } 
    
    // Cek apakah sesi sudah dipesan pada tanggal sewa tertentu
    public function isBookedOnDate($tanggalSewa, $sesiId)
    {
        return $this->sewaSpots()
                    ->where('tanggal_sewa', $tanggalSewa)
                    ->where('sesi_id', $sesiId)
                    ->whereIn('status', ['sudah dibayar', 'menunggu pembayaran'])
                    ->exists();
    }

    // Dapatkan sesi yang tersedia pada tanggal sewa tertentu
    public function getAvailableSessions($tanggalSewa, $currentSesi = null)
    {
        $bookedSessions = $this->sewaSpots()
                               ->where('tanggal_sewa', $tanggalSewa)
                               ->whereIn('status', ['menunggu pembayaran', 'sudah dibayar'])
                               ->pluck('sesi_id')
                               ->toArray();
    
        if ($currentSesi) {
            $bookedSessions = array_diff($bookedSessions, [$currentSesi]);
        }
    
        $allSessions = UpdateSesiSewaSpot::pluck('id')->toArray();
    
        $availableSessions = array_diff($allSessions, $bookedSessions);
    
        return $availableSessions;
    }    

    public function getUnavailableSessions($tanggalSewa)
    {
        return $this->sewaSpots()
                    ->where('tanggal_sewa', $tanggalSewa)
                    ->whereIn('status', ['menunggu pembayaran', 'sudah dibayar'])
                    ->pluck('sesi_id')
                    ->toArray();
    }
 
}
