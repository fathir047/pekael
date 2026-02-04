<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\bookings;
use App\Models\jadwals;
use App\Models\ruangans;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    public function create()
    {
        $ruangans = ruangans::all();
        return view('booking_create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        // =========================
        // VALIDASI INPUT
        // =========================
        $request->validate([
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        $tanggal     = Carbon::parse($request->tanggal);
        $jamMulai    = Carbon::parse($request->tanggal . ' ' . $request->jam_mulai);
        $jamSelesai  = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);

        // =========================
        // VALIDASI WAKTU
        // =========================
        if ($tanggal->lt(Carbon::today())) {
            toast('Tanggal sudah lewat!', 'error');
            return back()->withInput();
        }

        if ($tanggal->isToday() && $jamMulai->lt(Carbon::now())) {
            toast('Jam mulai sudah lewat!', 'error');
            return back()->withInput();
        }

        if ($jamSelesai->lte($jamMulai)) {
            toast('Jam selesai harus lebih besar dari jam mulai!', 'error');
            return back()->withInput();
        }

        // =========================
        // CEK BENTROK BOOKING LAIN
        // =========================
        $bentrokBooking = bookings::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->where('jam_mulai', '<', $request->jam_selesai)
                  ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($bentrokBooking) {
            toast('Ruangan sudah dibooking di jam tersebut!', 'error');
            return back()->withInput();
        }

        // =========================
        // CEK BENTROK JADWAL TETAP
        // =========================
        $bentrokJadwal = jadwals::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->where('jam_mulai', '<', $request->jam_selesai)
                  ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($bentrokJadwal) {
            toast('Bentrok dengan jadwal tetap!', 'error');
            return back()->withInput();
        }

        // =========================
        // CEK JEDA 30 MENIT
        // =========================
        $lastBooking = bookings::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam_selesai', '<=', $request->jam_mulai)
            ->orderBy('jam_selesai', 'desc')
            ->first();

        if ($lastBooking) {
            $lastEnd = Carbon::parse($request->tanggal . ' ' . $lastBooking->jam_selesai);
            $minStart = $jamMulai->copy()->subMinutes(30);

            if ($lastEnd->gt($minStart)) {
                toast('Harus ada jeda minimal 30 menit dari booking sebelumnya!', 'error');
                return back()->withInput();
            }
        }

        // =========================
        // SIMPAN BOOKING
        // =========================
        bookings::create([
            'user_id'     => Auth::id(),
            'ruang_id'    => $request->ruang_id,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status'      => 'Pending',
        ]);

        toast('Booking berhasil! Menunggu persetujuan.', 'success');
        return redirect()->route('bookings.create');
    }

    public function riwayat()
    {
        $booking = bookings::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tanggal_format = Carbon::parse($item->tanggal)
                    ->translatedFormat('l, d F Y');
                return $item;
            });

        return view('booking_riwayat', compact('booking'));
    }

    public function show()
    {
        $ruangan = ruangans::all();
        return view('ruangan', compact('ruangan'));
    }

    public function tampil($id)
    {
        $ruangan = ruangans::findOrFail($id);
        return view('ruangan_detail', compact('ruangan'));
    }
}
