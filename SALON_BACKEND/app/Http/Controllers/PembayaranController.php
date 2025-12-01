<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user instanceof \App\Models\Admin) {
            return response()->json(Pembayaran::with(['pemesanan.layanan', 'pemesanan.pelanggan', 'pemesanan.pegawai'])->get());
        }

        return response()->json(
            Pembayaran::with(['pemesanan.layanan'])
            ->whereHas('pemesanan', fn($q) =>
                $q->where('id_pelanggan', $user->id_pelanggan)
            )
            ->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required|exists:pemesanan,id_pemesanan',
            'metode_pembayaran' => 'required'
        ]);

        $order = Pemesanan::with('layanan')
            ->where('id_pemesanan', $request->id_pemesanan)
            ->where('id_pelanggan', auth()->user()->id_pelanggan)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Pemesanan tidak sesuai akun'], 403);
        }

        $pay = Pembayaran::create([
            'id_pemesanan' => $request->id_pemesanan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_bayar' => $order->layanan->harga,
            'tanggal_pembayaran' => now(),
            'status_pembayaran' => 'lunas'
        ]);

        $order->update(['status_pemesanan' => 'selesai']);

        return response()->json(['message' => 'Pembayaran berhasil!', 'data' => $pay]);
    }

    public function totalPendapatan()
    {
        return response()->json(['total' => Pembayaran::sum('total_bayar')]);
    }
}
