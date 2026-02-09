<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ParticipantLoginController extends Controller
{
    /**
     * Menampilkan form absensi harian (link global) dengan logika tanggal yang sudah diperbaiki.
     */
    public function showDailyForm(Request $request, $slug)
    {
        $presence = Presence::where('slug', $slug)->firstOrFail();

        // Ambil waktu saat ini, dengan timezone yang benar dari konfigurasi aplikasi Anda.
        $now = now(config('app.timezone'));

        // Ambil tanggal dan waktu selesai kegiatan, lalu ubah ke akhir hari (23:59:59).
        // Ini memastikan link aktif sepanjang hari di tanggal terakhir kegiatan.
        $eventRealEndDate = $presence->datetime_selesai->copy()->endOfDay();

        // Link dianggap ditutup JIKA:
        // 1. Status link di admin panel tidak aktif.
        // ATAU
        // 2. Waktu sekarang sudah melewati akhir hari dari tanggal selesai kegiatan.
        if (!$presence->is_link_active || $now->isAfter($eventRealEndDate)) {
            return view('pages.absen.event_ended', [
                'presence' => $presence,
            ]);
        }

        // Pemeriksaan tambahan: pastikan link tidak bisa diakses SEBELUM kegiatan dimulai.
        if ($now->isBefore($presence->datetime_mulai->copy()->startOfDay())) {
            return view('pages.absen.event_ended', [
                'presence' => $presence,
            ]);
        }

        // Jika semua pemeriksaan lolos, tampilkan halaman login NIK.
        return view('pages.absen.participant_login', [
            'presence' => $presence,
            'isMultiDayLink' => false,
            'today' => $now->toDateString(),
            'identity_number_from_session' => session('identity_number')
        ]);
    }

    /**
     * Menampilkan form untuk link multi-hari (tidak ada perubahan).
     */
    public function showMultiDayForm(Request $request, $slug)
    {
        $presence = Presence::where('slug', $slug)->firstOrFail();

        if (!$presence->is_link_active) {
            return view('pages.absen.event_ended', ['presence' => $presence]);
        }

        return view('pages.absen.participant_login', [
            'presence' => $presence,
            'isMultiDayLink' => true,
            'today' => null,
            'identity_number_from_session' => session('identity_number')
        ]);
    }

    /**
     * Memproses login NIK dari kedua form (sudah dimodifikasi).
     */
    public function login(Request $request, $slug)
    {
        // 1. Hapus validasi 'exists'
        // Sekarang sistem tidak lagi mengecek apakah NIK sudah terdaftar sebelumnya.
        try {
            $request->validate([
                'identity_number' => 'required|digits:16', // Hanya validasi format
                'tanggal_absensi' => 'required|date_format:Y-m-d',
            ], [
                'identity_number.required' => 'Silakan masukkan NIK Anda.',
                'identity_number.digits' => 'NIK harus 16 digit angka.',
            ]);
        } catch (ValidationException $e) {
            $redirectRoute = $request->has('is_multi_day_link')
                ? 'participant.login.form.multi'
                : 'participant.login.form.daily';

            return redirect()->route($redirectRoute, ['slug' => $slug])
                ->withErrors($e->validator)
                ->withInput();
        }

        $presence = Presence::where('slug', $slug)->firstOrFail();

        // 2. Tetap cek apakah NIK ini sudah absen untuk tanggal yang sama
        // Ini penting untuk mencegah data ganda.
        if (
            PresenceDetail::where('presence_id', $presence->id)
                ->where('identity_number', $request->identity_number)
                ->where('tanggal_absensi', $request->tanggal_absensi)
                ->exists()
        ) {
            // Jika datang dari link multi-hari, siapkan URL untuk tombol "lanjutkan"
            if ($request->has('is_multi_day_link')) {
                session()->put('continueUrl', route('participant.login.form.multi', ['slug' => $presence->slug]));
            }
            return redirect()->route('absen.thankyou')->with('thank_you_message', 'Anda sudah tercatat absensi untuk tanggal ini. Terima kasih.');
        }

        // 3. Jika validasi format lolos dan belum absen, simpan sesi dan lanjutkan
        session([
            'participant_authenticated' => true,
            'presence_id' => $presence->id,
            'identity_number' => $request->identity_number,
            'tanggal_absensi' => $request->tanggal_absensi,
            'is_multi_day_link' => $request->has('is_multi_day_link'),
        ]);

        return redirect()->route('absen.form', ['slug' => $slug]);
    }

    /**
     * API untuk mengambil tanggal tersedia (tidak ada perubahan).
     */
    public function getAvailableDatesForNik($presence_slug, $nik)
    {
        if (!preg_match('/^\d{16}$/', $nik)) {
            return response()->json(['error' => 'Format NIK tidak valid.'], 400);
        }
        $presence = Presence::where('slug', $presence_slug)->firstOrFail();
        $allPossibleDates = collect($presence->getAvailableDates());
        $attendedDates = PresenceDetail::where('presence_id', $presence->id)
            ->where('identity_number', $nik)
            ->pluck('tanggal_absensi')
            ->map(fn($date) => Carbon::parse($date)->toDateString());
        $availableDates = $allPossibleDates->reject(fn($date) => $attendedDates->contains(Carbon::parse($date)->toDateString()));
        $formattedDates = $availableDates->mapWithKeys(fn($date) => [$date => Carbon::parse($date)->translatedFormat('l, d F Y')]);
        return response()->json($formattedDates);
    }
}