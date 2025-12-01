<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user instanceof \App\Models\Admin) {
            return response()->json(Pemesanan::with(['pelanggan', 'layanan', 'pegawai'])->get());
        }

        return response()->json(
            Pemesanan::with(['layanan', 'pegawai'])
            ->where('id_pelanggan', $user->id_pelanggan)
            ->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'tanggal_booking' => 'required|date',
            'jam_booking' => 'required'
        ]);

        $pemesanan = Pemesanan::create([
            'id_pelanggan' => auth()->user()->id_pelanggan,
            'id_layanan' => $request->id_layanan,
            'id_pegawai' => $request->id_pegawai,
            'tanggal_pemesanan' => now(),
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking' => $request->jam_booking,
            'status_pemesanan' => 'pending'
        ]);

        return response()->json(['message' => 'Pemesanan berhasil', 'data' => $pemesanan]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required|exists:pemesanan,id_pemesanan',
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'tanggal_booking' => 'required|date',
            'jam_booking' => 'required'
        ]);

        $pemesanan = Pemesanan::find($request->id_pemesanan);
        $pemesanan->update($request->all());

        return response()->json(['message' => 'Update berhasil', 'data' => $pemesanan]);
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::find($id);

        if (!$pemesanan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $pemesanan->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
