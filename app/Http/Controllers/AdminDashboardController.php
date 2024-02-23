<?php

namespace App\Http\Controllers;

use App\Models\Visitors;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $visitors = Visitors::latest()->first();
        return view('admin.dashboard.index', compact('visitors'));
    }

    public function updatePengunjung(Request $request)
    {
        $request->validate([
            'jumlah' => 'integer'
        ]);

        $visitors = Visitors::first();
        $visitors->update(['jumlah' => $request->jumlah]);

        return redirect()->back()->with('success', 'Jumlah pengunjung berhasil diperbarui.');
    }


}
