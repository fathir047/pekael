<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\bookings;
use App\Models\ruangans;
use App\Models\jadwals;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* ===============================
        EXPORT PDF
    ================================ */
    public function export()
    {
        $filter = bookings::with(['user', 'ruangan']);

        if (request()->filled('ruang_id')) {
            $filter->where('ruang_id', request('ruang_id'));
        }

        if (request()->filled('tanggal')) {
            $filter->where('tanggal', request('tanggal'));
        }

        if (request()->filled('status')) {
            $filter->where('status', request('status'));
        }

        $bookings = $filter->orderBy('status')->get();

        $pdf = Pdf::loadView('backend.bookings.pdfbookings', compact('bookings'));
        return $pdf->download('laporan-data-bookings.pdf');
    }

    /* ===============================
        INDEX
    ================================ */
    public function index(Request $request)
    {
        // Auto set selesai
        bookings::where(function ($query) {
            $query->where('tanggal', '<', now()->toDateString())
                ->orWhere(function ($q) {
                    $q->where('tanggal', now()->toDateString())
                      ->where('jam_selesai', '<', now()->format('H:i:s'));
                });
        })
        ->where('status', '!=', 'Selesai')
        ->update(['status' => 'Selesai']);

        // Filter data
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

        $ruangans = ruangans::all();

        return view('backend.bookings.index', compact('bookings', 'ruangans'));
    }

    /* ===============================
        CREATE
    ================================ */
    public function create()
    {
        $ruangans = ruangans::all();
        $users = User::all();
        return view('backend.bookings.create', compact('ruangans', 'users'));
    }

    /* ===============================
        STORE
    ================================ */
    public function store(Request $request)
    {
        // Jam terlewat
        if ($request->tanggal == now()->toDateString()) {
            $jamSelesai = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);
            if ($jamSelesai->lt(now())) {
                toast('Jam sudah terlewat!', 'error');
                return back()->withInput();
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
            toast('Jadwal booking bentrok!', 'error');
            return back()->withInput();
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
            toast('Bentrok dengan jadwal tetap!', 'error');
            return back()->withInput();
        }

        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        bookings::create([
            'user_id'     => $request->user_id,
            'ruang_id'    => $request->ruang_id,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status'      => 'Pending',
        ]);

        toast('Booking berhasil ditambahkan', 'success');
        return redirect()->route('backend.bookings.index');
    }

    /* ===============================
        UPDATE STATUS (INDEX)
    ================================ */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Ditolak,Selesai'
        ]);

        $booking = bookings::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        toast('Status booking berhasil diperbarui', 'success');
        return back();
    }

    /* ===============================
        SHOW
    ================================ */
    public function show($id)
    {
        $booking = bookings::with(['ruangan', 'user'])->findOrFail($id);
        $booking->tanggal_format =
            Carbon::parse($booking->tanggal)->translatedFormat('l, j F Y');

        return view('backend.bookings.show', compact('booking'));
    }

    /* ===============================
        DESTROY
    ================================ */
    public function destroy($id)
    {
        bookings::findOrFail($id)->delete();
        toast('Booking berhasil dihapus', 'success');
        return back();
    }
}
