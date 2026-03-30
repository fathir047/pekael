<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\jadwals;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalApiController extends Controller
{
    public function index()
    {
        $jadwals = jadwals::with('ruangan')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($jadwal) {
                $jadwal->tanggal_format = Carbon::parse($jadwal->tanggal)
                    ->translatedFormat('l, j F Y');
                return $jadwal;
            });

        return response()->json([
            'status' => true,
            'message' => 'Data jadwal berhasil diambil',
            'data' => $jadwals
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required|string',
            'jam_selesai' => 'required|string',
            'ket'         => 'required|string',
        ]);

        $jadwal = new jadwals();

        $jadwal->ruang_id    = $request->ruang_id;
        $jadwal->tanggal     = $request->tanggal;
        $jadwal->jam_mulai   = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->ket         = $request->ket;
        $jadwal->save();

        return response()->json([
            'status' => true,
            'message' => 'Jadwal berhasil dibuat',
            'data' => $jadwal
        ], 201);
    }

    public function show($id)
    {
        $jadwal = jadwals::with('ruangan')->find($id);

        if (!$jadwal) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 404);
        }

        $jadwal->tanggal_format = Carbon::parse($jadwal->tanggal)
            ->translatedFormat('l, j F Y');

        return response()->json([
            'status' => true,
            'data' => $jadwal
        ]);
    }

    public function update(Request $request, $id)
    {
        $jadwal = jadwals::find($id);

        if (!$jadwal) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required|string',
            'jam_selesai' => 'required|string',
            'ket'         => 'required|string',
        ]);

        $jadwal->ruang_id    = $request->ruang_id;
        $jadwal->tanggal     = $request->tanggal;
        $jadwal->jam_mulai   = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->ket         = $request->ket;
        $jadwal->save();

        return response()->json([
            'status' => true,
            'message' => 'Jadwal berhasil diupdate',
            'data' => $jadwal
        ]);
    }

    public function destroy($id)
    {
        $jadwal = jadwals::find($id);

        if (!$jadwal) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 404);
        }

        $jadwal->delete();

        return response()->json([
            'status' => true,
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }
}
