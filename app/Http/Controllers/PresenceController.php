<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PresenceController extends Controller
{
    /**
     * Menampilkan daftar semua kegiatan.
     */
    public function index()
    {
        // PERUBAHAN: Menggunakan orderBy 'created_at' desc agar data terbaru muncul paling atas
        $presences = Presence::orderBy('created_at', 'desc')->paginate(10);

        return view("pages.presence.index", compact('presences'));
    }

    /**
     * Menampilkan form untuk membuat kegiatan baru.
     */
    public function create()
    {
        return view("pages.presence.create");
    }

    /**
     * Menyimpan kegiatan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai_kegiatan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
            'waktu_selesai' => 'required|date_format:H:i',
        ]);

        Presence::create([
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'slug' => Str::slug($request->nama_kegiatan . '-' . now()->timestamp),
            'datetime_mulai' => $request->tanggal_mulai_kegiatan . ' ' . $request->input('waktu_mulai') . ':00',
            'datetime_selesai' => $request->tanggal_selesai_kegiatan . ' ' . $request->input('waktu_selesai') . ':00',
        ]);

        return redirect()->route('admin.presence.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu kegiatan.
     */
    public function show(Request $request, $id)
    {
        $presence = Presence::findOrFail($id);
        $defaultViewDate = now(config('app.timezone'))->format('Y-m-d');
        if ($presence->datetime_mulai->isFuture() && !$request->has('view_date')) {
            $defaultViewDate = $presence->datetime_mulai->format('Y-m-d');
        } elseif ($presence->datetime_selesai->isPast() && !$request->has('view_date')) {
            $defaultViewDate = $presence->datetime_selesai->format('Y-m-d');
        }
        $selectedDate = $request->input('view_date', $defaultViewDate);
        if (Carbon::parse($selectedDate)->isBefore($presence->datetime_mulai->startOfDay()) || Carbon::parse($selectedDate)->isAfter($presence->datetime_selesai->endOfDay())) {
            $selectedDate = $presence->datetime_mulai->format('Y-m-d');
        }
        $presenceDetails = $presence->presenceDetails()->where('tanggal_absensi', $selectedDate)->latest()->get();
        $eventDates = [];
        if ($presence->datetime_mulai && $presence->datetime_selesai) {
            $currentListDate = $presence->datetime_mulai->copy()->startOfDay();
            $endDateLoop = $presence->datetime_selesai->copy()->endOfDay();
            while ($currentListDate->lte($endDateLoop)) {
                $eventDates[] = $currentListDate->copy()->format('Y-m-d');
                $currentListDate->addDay();
            }
        }

        $globalLink = route('participant.login.form.daily', ['slug' => $presence->slug]);
        $multiDayLink = route('participant.login.form.multi', ['slug' => $presence->slug]);

        return view('pages.presence.detail.index', compact('presence', 'presenceDetails', 'selectedDate', 'eventDates', 'globalLink', 'multiDayLink'));
    }

    /**
     * Menampilkan form untuk mengedit kegiatan.
     */
    public function edit($id)
    {
        $presence = Presence::findOrFail($id);
        return view("pages.presence.edit", compact('presence'));
    }

    /**
     * Memperbarui data kegiatan di database.
     */
    public function update(Request $request, $id)
    {
        $presence = Presence::findOrFail($id);
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai_kegiatan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
            'waktu_selesai' => 'required|date_format:H:i',
        ]);
        $presence->update([
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'datetime_mulai' => $request->tanggal_mulai_kegiatan . ' ' . $request->input('waktu_mulai') . ':00',
            'datetime_selesai' => $request->tanggal_selesai_kegiatan . ' ' . $request->input('waktu_selesai') . ':00',
        ]);
        return redirect()->route('admin.presence.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Menghapus data kegiatan dari database.
     */
    public function destroy($id)
    {
        $presence = Presence::findOrFail($id);
        $presence->presenceDetails()->delete();
        $presence->delete();
        return redirect()->route('admin.presence.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Mengubah status aktif/non-aktif dari link presensi.
     */
    public function toggleLinkStatus(Request $request, $id)
    {
        $presence = \App\Models\Presence::findOrFail($id);
        $presence->is_link_active = !$presence->is_link_active;
        $presence->save();
        $message = $presence->is_link_active ? 'Link kegiatan berhasil diaktifkan.' : 'Link kegiatan berhasil ditutup.';
        return redirect()->route('admin.presence.index')->with('success', $message);
    }
}