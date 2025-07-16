<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\jadwals;
use App\Models\ruangans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
        public function index() 
    {
        $jadwals = jadwals::orderBy('tanggal', 'desc')->get()->map(function ($jadwal) {
            $jadwal->tanggal_format = Carbon::parse($jadwal->tanggal)->translatedFormat('l, j F Y');
            return $jadwal;
        });

        $title = 'Hiii takotnya di hapuss T_T';
        $text  = 'Apakah anda yakin ingin menghapus jadwal ini?';
        confirmDelete($title, $text);

        return view('backend.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $ruangans  = ruangans::all();
        return view('backend.jadwal.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruang_id'       => 'required|',
            'tanggal'        => 'required|date|',
            'jam_mulai'      => 'required|string',
            'jam_selesai'    => 'required|',
            'ket'     => 'required|string',
        ]);

        
        $jadwals = new jadwals();

        $jadwals -> ruang_id    = $request->ruang_id;
        $jadwals -> tanggal     = $request->tanggal;
        $jadwals -> jam_mulai   = $request->jam_mulai;
        $jadwals -> jam_selesai = $request->jam_selesai;
        $jadwals -> ket         = $request->ket;
        $jadwals -> save();
        
        
        toast('Data ruangan berhasil disimpan.', 'success');
        return redirect()->route('backend.jadwal.index');

    }

    public function show(string $id)
    {   
    $jadwal = jadwals::findOrFail($id);
    $jadwal->tanggal_format = Carbon::parse($jadwal->tanggal)->translatedFormat('l, j F Y');
    
    return view('backend.jadwal.show', compact('jadwal'));
    }

        public function edit($id)
    {
        $jadwal = jadwals::findOrFail($id);
        $ruangans = ruangans::all();

        return view('backend.jadwal.edit', compact('jadwal', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ruang_id'    => 'required',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required|string',
            'jam_selesai' => 'required|string',
            'ket'         => 'required|string',
        ]);

        $jadwal = jadwals::findOrFail($id);

        $jadwal->ruang_id    = $request->ruang_id;
        $jadwal->tanggal     = $request->tanggal;
        $jadwal->jam_mulai   = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->ket         = $request->ket;
        $jadwal->save();

        toast('Jadwal berhasil diperbarui.', 'success');
        return redirect()->route('backend.jadwal.index');
    }
    
    public function destroy(string $id)
    {
        $jadwal = jadwals::findOrFail($id);
        $jadwal->delete();

        toast('Data jadwal berhasil dihapus.', 'success');
        return redirect()->route('backend.jadwal.index');
    }

}
