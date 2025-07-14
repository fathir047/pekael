<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\bookings;
use App\Models\ruangans;
use App\Models\jadwals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserBookingController extends Controller
{

    public function create()
    {
        $ruangans = ruangans::all();
        return view('booking_create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        
        $tanggalInput = Carbon::parse($request->tanggal)->format('Y-m-d');
        $hariIni = Carbon::now()->format('Y-m-d');

        if ($tanggalInput === $hariIni) {
            $jamSelesai = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);
            if ($jamSelesai->lt(Carbon::now())) {
                return back()
                    ->withInput()
                    ->with('error', 'Waktu booking sudah lewat. Silakan pilih waktu yang valid.');
            }
        }

        //  boking => boking bentrok
        $cekBentrok = bookings::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                        ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($cekBentrok) {
            toast('Jadwal ada yang boking !!', 'error');
            return back()->withInput();
        }


        // bentrok dengan jadwal tetap
        $bentrokJadwal = jadwals::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal) // cek tanggal yang sama
            ->where(function ($data) use ($request) {
                $data
                    ->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($jadwal) use ($request) {
                        $jadwal->where('jam_mulai', '<=', $request->jam_mulai)->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($bentrokJadwal) {
            toast('bentrok dengan jadwal tetap !!', 'error');
            return back()->withInput();
        }


        // waktu kosong harus 30 menit
        $lastBooking = bookings::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam_selesai', '<=', $request->jam_mulai)
            ->orderBy('jam_selesai', 'desc')
            ->first();

        if ($lastBooking) {
            $lastEnd = Carbon::parse($request->tanggal . ' ' . $lastBooking->jam_selesai);
            $newStart = Carbon::parse($request->tanggal . ' ' . $request->jam_mulai);

            if ($lastEnd->gt($newStart->subMinutes(30))) {
                toast('Harus ada jeda minimal 30 menit setelah pemakaian sebelumnya!', 'error');
                return back()->withInput()->with('error', 'Harus ada jeda minimal 30 menit setelah pemakaian sebelumnya!');
            }
        }

    

        $booking = new bookings();
        $booking->user_id     = Auth::id();
        $booking->ruang_id    = $request->ruang_id;
        $booking->tanggal     = $request->tanggal;
        $booking->jam_mulai   = $request->jam_mulai;
        $booking->jam_selesai = $request->jam_selesai;
        $booking->status      = 'Pending';
        $booking->save();

        toast('Kalem dagoan', 'success');
        return redirect()->route('bookings.create');
    }

    public function riwayat()
{
    $booking = bookings::where('user_id', Auth::id())
        ->orderBy('tanggal', 'desc')
        ->get()
        ->map(function ($item) {
            $item->tanggal_format = Carbon::parse($item->tanggal)->translatedFormat('l, j F Y');
            return $item;
        });

    return view('booking_riwayat', compact('booking'));
}

    public function show()
    {
        $ruangan = ruangans::all();
        return view('ruangan', compact('ruangan'));
    }

    public function tampil(string $id)
    {
        $ruangan = ruangans::findOrFail($id);
        return view('ruangan_detail', compact('ruangan'));
    }
}
