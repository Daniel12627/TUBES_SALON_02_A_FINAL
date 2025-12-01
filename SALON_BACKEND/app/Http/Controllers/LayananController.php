<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        return response()->json(Layanan::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_layanan' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric'
        ]);

        $layanan = Layanan::create($data);

        return response()->json([
            'message' => 'Layanan berhasil ditambahkan',
            'data' => $layanan
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'nama_layanan' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric'
        ]);

        $layanan = Layanan::findOrFail($request->id_layanan);
        $layanan->update($data);

        return response()->json([
            'message' => 'Layanan berhasil diperbarui',
            'data' => $layanan
        ]);
    }

    public function destroy($id_layanan)
    {
        $layanan = Layanan::find($id_layanan);

        if (!$layanan) {
            return response()->json(['message' => 'Layanan tidak ditemukan'], 404);
        }

        $layanan->delete();

        return response()->json(['message' => 'Layanan berhasil dihapus']);
    }
}
