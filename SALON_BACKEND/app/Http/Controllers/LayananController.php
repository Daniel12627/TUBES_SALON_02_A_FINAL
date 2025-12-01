<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function __construct()
    {
        // Semua aksi hanya boleh ADMIN
        $this->middleware('admin');
    }

    public function index()
    {
        return response()->json(Layanan::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric'
        ]);

        $layanan = Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        return response()->json([
            'message' => 'Layanan berhasil ditambahkan',
            'data' => $layanan
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'nama_layanan' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric'
        ]);

        $layanan = Layanan::find($request->id_layanan);

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        return response()->json([
            'message' => 'Layanan berhasil diperbarui',
            'data' => $layanan
        ]);
    }

    public function destroy($id_layanan)
    {
        $layanan = Layanan::find($id_layanan);

        if (!$layanan) {
            return response()->json([
                'message' => 'Layanan tidak ditemukan'
            ], 404);
        }

        $layanan->delete();

        return response()->json([
            'message' => 'Layanan berhasil dihapus'
        ]);
    }
}
