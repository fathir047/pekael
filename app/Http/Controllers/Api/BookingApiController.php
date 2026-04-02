<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\bookings;
use App\Models\jadwals;
use Carbon\Carbon;

class BookingApiController extends Controller
{
    /* ===============================
        INDEX + FILTER
    ================================ */
    public function index(Request $request)
    {
        // Auto update status selesai
        bookings::where(function ($query) {
            $query->where('tanggal', '<', now()->toDateString())
                ->orWhere(function ($q) {
                    $q->where('tanggal', now()->toDateString())
                      ->where('jam_selesai', '<', now()->format('H:i:s'));
                });
        })
        ->where('status', '!=', 'Selesai')
        ->update(['status' => 'Selesai']);

        $query = bookings::with(['ruangan', 'user'])
            ->orderBy('tanggal', 'desc');

        if ($request->filled('ruang_id')) {
            $query->where('ruang_id', $request->ruang_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->get()->map(function ($booking) {
            $booking->tanggal_format =
                Carbon::parse($booking->tanggal)->translatedFormat('l, j F Y');
            return $booking;
        });

        return response()->json([
            'status' => true,
            'data' => $bookings
        ]);
    }

    /* ===============================
        STORE
    ================================ */
    public function store(Request $request)
    {
        // Validasi awal
        $request->validate([
            'user_id'     => 'nullable|exists:users,id',
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Cek jam terlewat
        if ($request->tanggal == now()->toDateString()) {
            $jamSelesai = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);
            if ($jamSelesai->lt(now())) {
                return response()->json([
                    'status' => false,
                    'message' => 'Jam sudah terlewat!'
                ], 400);
            }
        }

        // Bentrok booking
        $cekBentrok = bookings::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function ($sub) use ($request) {
                      $sub->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })
            ->exists();

        if ($cekBentrok) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal booking bentrok!'
            ], 400);
        }

        // Bentrok jadwal tetap
        $bentrokJadwal = jadwals::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function ($sub) use ($request) {
                      $sub->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })
            ->exists();

        if ($bentrokJadwal) {
            return response()->json([
                'status' => false,
                'message' => 'Bentrok dengan jadwal tetap!'
            ], 400);
        }

        $booking = bookings::create([
            'user_id'     => Auth::id(),
            'ruang_id'    => $request->ruang_id,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status'      => 'Pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Booking berhasil dibuat',
            'data' => $booking
        ], 201);
    }

    /* ===============================
        SHOW
    ================================ */
    public function show($id)
    {
        $booking = bookings::with(['ruangan', 'user'])->find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        $booking->tanggal_format =
            Carbon::parse($booking->tanggal)->translatedFormat('l, j F Y');

        return response()->json([
            'status' => true,
            'data' => $booking
        ]);
    }

    /* ===============================
        UPDATE STATUS
    ================================ */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Ditolak,Selesai'
        ]);

        $booking = bookings::find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        $booking->status = $request->status;
        $booking->save();

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diupdate',
            'data' => $booking
        ]);
    }

    /* ===============================
        DESTROY
    ================================ */
    public function destroy($id)
    {
        $booking = bookings::find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'status' => true,
            'message' => 'Booking berhasil dihapus'
        ]);
    }
}
