<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SewaSpot;
use Carbon\Carbon; // Gunakan Carbon untuk manipulasi waktu

class MemberSewaSpotController extends Controller
{
    public function index()
    {
        $spots = [
            ['id' => 1, 'nomor_spot' => '01'],
            ['id' => 2, 'nomor_spot' => '02'],
            ['id' => 3, 'nomor_spot' => '03'],
            ['id' => 4, 'nomor_spot' => '04'],
            ['id' => 5, 'nomor_spot' => '05'],
            ['id' => 6, 'nomor_spot' => '06'],
            ['id' => 7, 'nomor_spot' => '07'],
            ['id' => 8, 'nomor_spot' => '08'],
            ['id' => 9, 'nomor_spot' => '09'],
            ['id' => 10, 'nomor_spot' => '10'],
            ['id' => 11, 'nomor_spot' => '11'],
            ['id' => 12, 'nomor_spot' => '12'],
            ['id' => 13, 'nomor_spot' => '13'],
            ['id' => 14, 'nomor_spot' => '14'],
            ['id' => 15, 'nomor_spot' => '15'],
            ['id' => 16, 'nomor_spot' => '16'],
            ['id' => 17, 'nomor_spot' => '17'],
            ['id' => 18, 'nomor_spot' => '18'],
            ['id' => 19, 'nomor_spot' => '19'],
            ['id' => 20, 'nomor_spot' => '20'],
            ['id' => 21, 'nomor_spot' => '21'],
            ['id' => 22, 'nomor_spot' => '22'],
            ['id' => 23, 'nomor_spot' => '23'],
            ['id' => 24, 'nomor_spot' => '24'],
            ['id' => 25, 'nomor_spot' => '25'],
            ['id' => 26, 'nomor_spot' => '26'],
            ['id' => 27, 'nomor_spot' => '27'],
            ['id' => 28, 'nomor_spot' => '28'],
            ['id' => 29, 'nomor_spot' => '29'],
            ['id' => 30, 'nomor_spot' => '30'],
            ['id' => 31, 'nomor_spot' => '31'],
            ['id' => 32, 'nomor_spot' => '32'],
            ['id' => 33, 'nomor_spot' => '33'],
            ['id' => 34, 'nomor_spot' => '34'],
            ['id' => 35, 'nomor_spot' => '35'],
            ['id' => 36, 'nomor_spot' => '36'],
            ['id' => 37, 'nomor_spot' => '37'],
            ['id' => 38, 'nomor_spot' => '38'],
            ['id' => 39, 'nomor_spot' => '39'],
            ['id' => 40, 'nomor_spot' => '40'],
        ];
        

        return view('member.sewaspotpemancingan.sewa-pemancingan', compact('spots'));
    }

    public function pesanSpot(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'tanggal_sewa' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'spot_id' => 'required|integer',
        ]);

        // Cek apakah spot sudah dipesan sebelumnya
        $sewaSpotLain = SewaSpot::where('spot_id', $request->input('spot_id'))
            ->where('tanggal_sewa', $request->input('tanggal_sewa'))
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('jam_mulai', '<=', $request->input('jam_mulai'))
                        ->where('jam_selesai', '>=', $request->input('jam_mulai'));
                })->orWhere(function ($q) use ($request) {
                    $q->where('jam_mulai', '<=', $request->input('jam_selesai'))
                        ->where('jam_selesai', '>=', $request->input('jam_selesai'));
                });
            })->first();

        if ($sewaSpotLain) {
            return response()->json(['message' => 'Spot sudah dipesan pada waktu tersebut'], 400);
        }

        // Simpan SewaSpot ke database
        $sewaSpot = new SewaSpot();
        $sewaSpot->nama_pelanggan = $request->input('nama_pelanggan');
        $sewaSpot->tanggal_sewa = $request->input('tanggal_sewa');
        $sewaSpot->jam_mulai = $request->input('jam_mulai');
        $sewaSpot->jam_selesai = $request->input('jam_selesai');
        $sewaSpot->spot_id = $request->input('spot_id');
        $sewaSpot->status = 'menunggu_pembayaran'; // Status awal SewaSpot
        $sewaSpot->save();

        // Tambahkan logika lain seperti pengaturan status SewaSpot otomatis setelah 24 jam
        $this->aturStatusSewaSpot($sewaSpot);

        return response()->json(['message' => 'Sewa Spot Pemancingan berhasil disimpan'], 201);
    }

    // Method untuk mengatur status SewaSpot berdasarkan aturan yang disebutkan
    private function aturStatusSewaSpot($sewaSpot)
    {
        $waktuSewa = Carbon::parse($sewaSpot->tanggal_sewa . ' ' . $sewaSpot->jam_mulai);
        $waktuSekarang = Carbon::now();

        // Apabila waktu sekarang melewati 24 jam dari waktu sewa dan SewaSpot belum dibayar
        if ($waktuSekarang->diffInHours($waktuSewa) >= 24 && $sewaSpot->status === 'menunggu_pembayaran') {
            $sewaSpot->status = 'dibatalkan';
            $sewaSpot->save();
        }

        // Atur kembali spot menjadi tersedia jika waktu selesai sewa sudah lewat
        $waktuSelesai = Carbon::parse($sewaSpot->tanggal_sewa . ' ' . $sewaSpot->jam_selesai);
        if ($waktuSekarang->greaterThanOrEqualTo($waktuSelesai)) {
            $sewaSpot->status = 'tersedia';
            $sewaSpot->save();
        }
    }
}