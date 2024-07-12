<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SewaSpot;
use App\Models\Spot;

class GuestSpotController extends Controller
{
    public function index()
    {
        $spots = Spot::all();
        // $sewaSpots = SewaSpot::all()->groupBy('spot_id');
        $sewaSpots = SewaSpot::where('tanggal_sewa', '>=', Carbon::today())->get()->groupBy('spot_id');
        return view('Guest.SewaSpot.spot', compact('spots', 'sewaSpots'));
    }
}
