<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ruangans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RuanganApiController extends Controller
{
    public function index()
    {
        $ruangans = ruangans::latest()->get();

        foreach ($ruangans as $ruangan) {
            $ruangan->cover = $ruangan->cover
                ? url('storage/' . $ruangan->cover)
                : null;
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ruangan berhasil diambil',
            'data' => $ruangans
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255|unique:ruangans',
            'kapasitas' => 'required|string|max:255',
            'fasilitas' => 'required|string',
            'cover'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ruangan = new ruangans();

        if ($request->hasFile('cover')) {
            $file       = $request->file('cover');
            $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $coverPath  = $file->storeAs('cover-ruangan', $randomName, 'public');
            $ruangan->cover = $coverPath;
        }

        $ruangan->nama      = $request->nama;
        $ruangan->kapasitas = $request->kapasitas;
        $ruangan->fasilitas = $request->fasilitas;
        $ruangan->save();

        return response()->json([
            'status' => true,
            'message' => 'Ruangan berhasil dibuat',
            'data' => $ruangan
        ], 201);
    }

    public function show($id)
    {
        $ruangan = ruangans::find($id);

        if (!$ruangan) {
            return response()->json([
                'status' => false,
                'message' => 'Ruangan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $ruangan
        ]);
    }

    public function update(Request $request, $id)
    {
        $ruangan = ruangans::find($id);

        if (!$ruangan) {
            return response()->json([
                'status' => false,
                'message' => 'Ruangan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama'      => 'required|string|max:255|unique:ruangans,nama,' . $id,
            'kapasitas' => 'required|string|max:255',
            'fasilitas' => 'required|string',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($ruangan->cover) {
                Storage::disk('public')->delete($ruangan->cover);
            }

            $file       = $request->file('cover');
            $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $coverPath  = $file->storeAs('cover-ruangan', $randomName, 'public');
            $ruangan->cover = $coverPath;
        }

        $ruangan->nama      = $request->nama;
        $ruangan->kapasitas = $request->kapasitas;
        $ruangan->fasilitas = $request->fasilitas;
        $ruangan->save();

        return response()->json([
            'status' => true,
            'message' => 'Data ruangan berhasil diupdate',
            'data' => $ruangan
        ]);
    }

    public function destroy($id)
    {
        $ruangan = ruangans::find($id);

        if (!$ruangan) {
            return response()->json([
                'status' => false,
                'message' => 'Ruangan tidak ditemukan'
            ], 404);
        }

        if ($ruangan->cover) {
            Storage::disk('public')->delete($ruangan->cover);
        }

        $ruangan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data ruangan berhasil dihapus'
        ]);
    }
}
