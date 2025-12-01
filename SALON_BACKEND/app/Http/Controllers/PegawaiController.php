<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        return response()->json(Pegawai::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        $pegawai = Pegawai::create($request->all());

        return response()->json(['message' => 'Pegawai ditambahkan', 'data' => $pegawai]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai'
        ]);

        $pegawai = Pegawai::find($request->id_pegawai);
        $pegawai->update($request->all());

        return response()->json(['message' => 'Update pegawai berhasil', 'data' => $pegawai]);
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);

        if (!$pegawai) {
            return response()->json(['message' => 'Pegawai tidak ditemukan'], 404);
        }

        $pegawai->delete();
        return response()->json(['message' => 'Pegawai berhasil dihapus']);
    }
}
