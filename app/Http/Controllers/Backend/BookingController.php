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

    public function export()
    {   
        $filter = bookings::with(['User', 'ruangan']);

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

        $pdf = Pdf::loadView('backend.bookings.pdfbookings', ['bookings' => $bookings]);
        return $pdf->download('laporan-data-bookings.pdf');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        bookings::where(function ($query) {
            $query->where('tanggal', '<', now()->toDateString())->orWhere(function ($q) 
            {$q->where('tanggal', now()->toDateString())->where('jam_selesai', '<', now()->format('H:i:s'));         
        });

        })
        ->where('status', '!=', 'Selesai')
        ->update(['status' => 'Selesai']);

        //mengambil filter
        $query = bookings::with(['ruangan', 'user'])->orderBy('tanggal', 'desc');

        if ($request->filled('ruang_id')) {
            $query->where('ruang_id', $request->ruang_id);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // format tanggal
        $bookings = $query->get()->map(function($booking) {
            $booking->tanggal_format = Carbon::parse($booking->tanggal)->translatedFormat('l, j F Y');
            return $booking;
        });

        $ruangans = ruangans::all();

        confirmDelete('Hapus Booking', 'Apakah Anda yakin ingin menghapus booking ini?');
        return view('backend.bookings.index', compact('bookings', 'ruangans'));
    }

    public function create()
    {
        $ruangans = ruangans::all();
        $users = User::all();
        return view('backend.bookings.create', compact('ruangans', 'users'));
    }

    public function store(Request $request)
    {

        // jam terlewat
        $tanggalInput = Carbon::parse($request->tanggal)->format('Y-m-d');
        $hariIni = Carbon::now()->format('Y-m-d');

        if ($tanggalInput === $hariIni) {
            $jamSelesai = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);
            if ($jamSelesai->lt(Carbon::now())) {
                toast('jam udah kelewat !!', 'error');
                return back()->withInput()->with('error', 'Waktu booking sudah lewat. Silakan pilih waktu yang valid.');
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
            toast('Jadwal booking bentrok !!', 'error');
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

        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $booking = new bookings;
        $booking->user_id     = $request->user_id;
        $booking->ruang_id    = $request->ruang_id;
        $booking->tanggal     = $request->tanggal;
        $booking->jam_mulai   = $request->jam_mulai;
        $booking->jam_selesai = $request->jam_selesai;
        $booking->status      = 'Pending';
        $booking->save();

        toast('Booking berhasil ditambahkan.', 'success');
        return redirect()->route('backend.bookings.index');

    }

    public function show($id)
    {
        $booking = bookings::with(['ruangan', 'user'])->findOrFail($id);
        $booking->tanggal_format = Carbon::parse($booking->tanggal)->translatedFormat('l, j F Y');
        return view('backend.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = bookings::findOrFail($id);
        $ruangans = ruangans::all();
        $users = User::all();
        return view('backend.bookings.edit', compact('booking', 'ruangans', 'users'));
    }

    public function update(Request $request, $id)
    {

        // jam terlewat
        $tanggalInput = Carbon::parse($request->tanggal)->format('Y-m-d');
        $hariIni = Carbon::now()->format('Y-m-d');

        if ($tanggalInput === $hariIni) {
            $jamSelesai = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);
            if ($jamSelesai->lt(Carbon::now())) {

                toast('jam udah kelewat!!', 'error');
                return back()->withInput()->with('error', 'Waktu booking sudah lewat. Silakan pilih waktu yang valid.');
            }
        }

         //  boking => boking bentrok
        $cekBentrok = bookings::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
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
            toast('Jadwal booking bentrok !!', 'error');
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

        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'ruang_id'    => 'required|exists:ruangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status'      => 'required|in:Pending,Diterima,Ditolak,Selesai',
        ]);

        $booking = bookings::findOrFail($id);
        $booking->user_id     = $request->user_id;
        $booking->ruang_id    = $request->ruang_id;
        $booking->tanggal     = $request->tanggal;
        $booking->jam_mulai   = $request->jam_mulai;
        $booking->jam_selesai = $request->jam_selesai;
        $booking->status      = $request->status;
        $booking->save();

        toast('Booking berhasil diperbarui.', 'success');
        return redirect()->route('backend.bookings.index');
    }

    public function destroy($id)
    {
        $booking = bookings::findOrFail($id);
        $booking->delete();

        toast('Booking berhasil dihapus.', 'success');
        return redirect()->route('backend.bookings.index');
    }
}