<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

// --- TAMBAHAN IMPORT UNTUK FITUR EMAIL ---
use Illuminate\Support\Facades\Mail;
use App\Mail\AbsensiConfirmation;

class AbsenController extends Controller
{
    /**
     * Menampilkan form absensi akhir.
     */
    public function index(Request $request, $slug)
    {
        $presence = Presence::where('slug', $slug)->firstOrFail();
        $identity_number = session('identity_number');
        $tanggal_absensi = session('tanggal_absensi');

        if (!$identity_number || !$tanggal_absensi) {
            return redirect()->route('participant.login.form.daily', ['slug' => $slug])->withErrors(['auth' => 'Sesi Anda telah berakhir, silakan masukkan NIK kembali.']);
        }

        $lastSubmissionOverall = PresenceDetail::where('identity_number', $identity_number)->latest()->first();

        return view('pages.absen.index', [
            'presence' => $presence,
            'lastSubmissionOverall' => $lastSubmissionOverall,
            'identity_number' => $identity_number,
            'tanggal_absensi' => $tanggal_absensi,
        ]);
    }

    /**
     * Menyimpan data absensi, mengirim notifikasi email, dan mengarahkan ke halaman "Terima Kasih".
     */
    public function save(Request $request, Presence $presence)
    {
        $identityNumberFromSession = session('identity_number');
        $tanggal_absensi = $request->input('tanggal_absensi');

        if (!$identityNumberFromSession || !$tanggal_absensi) {
            return redirect()->route('participant.login.form.daily', ['slug' => $presence->slug])->withErrors(['auth' => 'Sesi Anda tidak valid atau telah berakhir.']);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'instansi' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:255',
            'no_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:255',
            'npwp' => 'required|string|max:50',
            'golongan' => 'nullable|string|max:50',
            'signature' => 'required|string',
        ], ['signature.required' => 'Tanda tangan wajib diisi.']);

        $base64_image = $request->signature;
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image));
        $signatureFileName = 'tanda-tangan/' . Str::uuid() . '.png';
        Storage::disk('public_uploads')->put($signatureFileName, $imageData);

        // 1. Simpan Data Absen Baru (Ditampung ke variabel $detail)
        $detail = PresenceDetail::create([
            'presence_id' => $presence->id,
            'tanggal_absensi' => $tanggal_absensi,
            'identity_number' => $identityNumberFromSession,
            'identity_type' => 'NIK',
            'tanda_tangan' => $signatureFileName,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'instansi' => $request->instansi,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'atas_nama' => $request->atas_nama,
            'npwp' => $request->npwp,
            'golongan' => $request->golongan
        ]);

        // ============================================================
        // --- LOGIKA KIRIM EMAIL NOTIFIKASI (BARU) ---
        // ============================================================
        try {
            // Cek nama kolom judul kegiatan (antisipasi beda nama kolom di db)
            $eventName = $presence->nama_kegiatan ?? $presence->judul ?? $presence->title ?? 'Kegiatan';

            // Kirim Email ke alamat yang diinput user
            Mail::to($request->email)->send(new AbsensiConfirmation($detail, $eventName));

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        // ============================================================


        // 2. Ambil Riwayat Absensi User Tersebut (History)
        $history = PresenceDetail::with('presence')
            ->where('identity_number', $identityNumberFromSession)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Logika Penentuan Sisa Tanggal
        $period = \Carbon\CarbonPeriod::create($presence->datetime_mulai, $presence->datetime_selesai);
        $allPossibleDates = collect();
        foreach ($period as $date) {
            $allPossibleDates->push($date->toDateString());
        }

        $attendedDates = PresenceDetail::where('presence_id', $presence->id)
            ->where('identity_number', $identityNumberFromSession)
            ->pluck('tanggal_absensi')
            ->map(fn($date) => Carbon::parse($date)->toDateString());

        $availableDates = $allPossibleDates->diff($attendedDates);

        $redirect = redirect()->route('absen.thankyou');

        // 4. Logika Redirect & Pesan
        $message = 'Terima kasih! Absensi Anda untuk tanggal <strong>' . Carbon::parse($tanggal_absensi)->translatedFormat('d F Y') . '</strong> telah berhasil dicatat.';

        if ($availableDates->isNotEmpty() && session('is_multi_day_link') === true) {
            // Jika masih ada tanggal & link multi
            $redirect->with('thank_you_message', $message)
                ->with('continueUrl', route('participant.login.form.multi', ['slug' => $presence->slug]));
        } else {
            // Jika selesai semua atau link single
            if ($availableDates->isEmpty()) {
                $message = 'Terima kasih! Anda telah menyelesaikan absensi untuk seluruh tanggal kegiatan ini.';
            }
            $redirect->with('thank_you_message', $message);
        }

        // Sertakan data history ke session flash
        $redirect->with('history', $history);

        // Bersihkan session
        $request->session()->forget(['identity_number', 'tanggal_absensi', 'participant_authenticated', 'presence_id', 'is_multi_day_link']);

        return $redirect;
    }
}