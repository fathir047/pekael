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
        // Validasi awal
        $request->validate([
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $tanggalBooking    = Carbon::parse($request->tanggal);
        $jamMulaiBooking   = Carbon::parse($request->tanggal . ' ' . $request->jam_mulai);
        $jamSelesaiBooking = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);

        // Cek tanggal tidak boleh lewat
        if ($tanggalBooking->lt(Carbon::today())) {
            toast('Tanggal booking sudah lewat. Silakan pilih tanggal yang valid.', 'error');
            return back()->withInput();
        }

        // Jika booking hari ini, cek jam mulai tidak boleh lewat
        if ($tanggalBooking->isToday() && $jamMulaiBooking->lt(Carbon::now())) {
            toast('Jam mulai booking sudah lewat. Silakan pilih jam yang valid.', 'error');
            return back()->withInput();
        }

        // Cek bentrok dengan booking lain
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
            toast('Jadwal ada yang booking!', 'error');
            return back()->withInput();
        }

        // Cek bentrok dengan jadwal tetap
        $bentrokJadwal = jadwals::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($data) use ($request) {
                $data->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($jadwal) use ($request) {
                        $jadwal->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($bentrokJadwal) {
            toast('Bentrok dengan jadwal tetap!', 'error');
            return back()->withInput();
        }

        // Cek jeda minimal 30 menit
        $lastBooking = bookings::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam_selesai', '<=', $request->jam_mulai)
            ->orderBy('jam_selesai', 'desc')
            ->first();

        if ($lastBooking) {
            $lastEnd = Carbon::parse($request->tanggal . ' ' . $lastBooking->jam_selesai);
            if ($lastEnd->gt($jamMulaiBooking->subMinutes(30))) {
                toast('Harus ada jeda minimal 30 menit setelah pemakaian sebelumnya!', 'error');
                return back()->withInput();
            }
        }

        // Simpan booking
        $booking              = new bookings();
        $booking->user_id     = Auth::id();
        $booking->ruang_id    = $request->ruang_id;
        $booking->tanggal     = $request->tanggal;
        $booking->jam_mulai   = $request->jam_mulai;
        $booking->jam_selesai = $request->jam_selesai;
        $booking->status      = 'Pending';
        $booking->save();

        toast('Booking berhasil! Tunggu ya.', 'success');
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
