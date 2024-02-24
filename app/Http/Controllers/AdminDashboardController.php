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
        // return view('admin.dashboard.index');
    }

    public function updatePengunjung(Request $request)
    {
        $request->validate([
            'jumlah' => 'integer'
        ]);

        if ($request->has('jumlah')) {
            Visitors::create([
                'jumlah' => $request->jumlah
            ]);
        }

        return redirect()->back()->with('success', 'Jumlah pengunjung berhasil diperbarui.');
    }


}
