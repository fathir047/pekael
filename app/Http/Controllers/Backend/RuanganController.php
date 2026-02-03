<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ruangans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = ruangans::latest()->get();

        $title = 'takut ga sama gurita?!';
        $text  = "Apakah anda yakin ingin menghapus ruangan ini?";
        confirmDelete($title, $text);

        return view('backend.ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        return view('backend.ruangan.create');
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

        toast('ruang berhasil dibuat', 'success');
        return redirect()->route('backend.ruangan.index');
    }

    public function show(string $id)
    {
        $ruangan = ruangans::findOrFail($id);
        return view('backend.ruangan.show', compact('ruangan'));
    }

    public function edit(string $id)
    {
        $ruangan = ruangans::findOrFail($id);
        return view('backend.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'      => 'required|string|max:255|unique:ruangans,nama,' . $id,
            'kapasitas' => 'required|string|max:255',
            'fasilitas' => 'required|string',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ruangan = ruangans::findOrFail($id);

        if ($request->hasFile('cover')) {
            Storage::disk('public')->delete($ruangan->cover);
            $file       = $request->file('cover');
            $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $coverPath  = $file->storeAs('cover-ruangan', $randomName, 'public');
            $ruangan->cover = $coverPath;
        }

        $ruangan->nama      = $request->nama;
        $ruangan->kapasitas = $request->kapasitas;
        $ruangan->fasilitas = $request->fasilitas;
        $ruangan->save();

        toast('Data ruangan berhasil diupdate.', 'success');
        return redirect()->route('backend.ruangan.index');
    }

    public function destroy(string $id)
    {
        $ruangan = ruangans::findOrFail($id);
        Storage::disk('public')->delete($ruangan->cover);
        $ruangan->delete();
 
        toast('Data ruangan berhasil dihapus.', 'success');
        return redirect()->route('backend.ruangan.index');
    }
}
