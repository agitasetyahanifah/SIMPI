<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SewaSpot;
use App\Models\Spot;
use App\Models\UpdateHargaSewaSpot;
use App\Models\UpdateSesiSewaSpot;

class GuestSpotController extends Controller
{
    public function index()
    {
        // Mengambil semua sesi
        $sessions = UpdateSesiSewaSpot::all();

        // Mengambil harga non member terbaru
        $latestNonMemberPrice = UpdateHargaSewaSpot::where('status_member', 'non member')->latest()->first();
        $nonMemberPrice = $latestNonMemberPrice ? $latestNonMemberPrice->harga : 0;

        $spots = Spot::all();
        // $sewaSpots = SewaSpot::all()->groupBy('spot_id');
        $sewaSpots = SewaSpot::where('tanggal_sewa', '>=', Carbon::today())->get()->groupBy('spot_id');
        return view('Guest.SewaSpot.spot', compact('spots', 'sewaSpots','nonMemberPrice', 'sessions'));
    }

    public function checkAvailability(Request $request)
    {
        $spotId = $request->query('spot_id');
        $selectedDate = $request->query('tanggal_sewa');
    
        if (!$spotId || !$selectedDate) {
            return response()->json(['disabled_sesi' => [], 'available_spots' => []]);
        }
    
        $spot = Spot::find($spotId);
    
        if (!$spot) {
            return response()->json(['disabled_sesi' => [], 'available_spots' => []]);
        }
    
        $unavailableSessions = $spot->getUnavailableSessions($selectedDate);
    
        // Mengambil semua spot
        $allSpots = Spot::pluck('id')->toArray();
        $availableSpots = [];
    
        foreach ($allSpots as $id) {
            $currentSpot = Spot::find($id);
            $availableSessions = $currentSpot->getAvailableSessions($selectedDate);
            if (!empty($availableSessions)) {
                $availableSpots[] = $id;
            }
        }
    
        return response()->json([
            'disabled_sesi' => $unavailableSessions,
            'available_spots' => $availableSpots,
        ]);
    }

}
