<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Reservation;

class MemberSpotController extends Controller
{
    public function index()
    {
        $spots = Spot::all();
        return view('member.sewaspotpemancingan.sewa-spot', compact('spots'));
    }

    public function reserve(Request $request)
    {
        $request->validate([
            'spots' => 'required|array',
            'spots.*' => 'exists:spots,id',
        ]);

        foreach ($request->spots as $spotId) {
            $spot = Spot::findOrFail($spotId);
            if ($spot->is_reserved) {
                return redirect()->back()->with('error', 'Spot already reserved');
            }

            $spot->update(['is_reserved' => true]);
            Reservation::create([
                'user_id' => auth()->id(),
                'spot_id' => $spotId,
            ]);
        }

        return redirect()->route('spots.index')->with('success', 'Spots reserved successfully');
    }
}
