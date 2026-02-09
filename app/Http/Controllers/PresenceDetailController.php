<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan package ini sudah terinstal
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PresenceDetailController extends Controller
{
    /**
     * Mengekspor data absensi ke PDF untuk tanggal tertentu.
     * $id adalah ID dari Presence (kegiatan).
     */
    public function exportPdf(Request $request, string $id)
    {
        $presence = Presence::findOrFail($id);

        // Ambil 'export_date' dari query string URL.
        $defaultExportDate = $presence->datetime_mulai ? $presence->datetime_mulai->format('Y-m-d') : now()->format('Y-m-d');
        $exportDate = $request->input('export_date', $defaultExportDate);

        // Validasi (opsional) apakah $exportDate berada dalam rentang kegiatan
        if ($presence->datetime_mulai && $presence->datetime_selesai) {
            if (Carbon::parse($exportDate)->lt($presence->datetime_mulai->startOfDay()) || Carbon::parse($exportDate)->gt($presence->datetime_selesai->endOfDay())) {
                $exportDate = $presence->datetime_mulai->format('Y-m-d');
            }
        }

        // Ambil detail absensi untuk kegiatan ini PADA TANGGAL $exportDate
        $presenceDetails = PresenceDetail::where('presence_id', $id)
                            ->where('tanggal_absensi', $exportDate) // Filter berdasarkan tanggal
                            ->orderBy('created_at', 'asc')
                            ->get();

        // Pastikan view 'pages.presence.detail.export-pdf' ada dan disesuaikan
        $pdf = Pdf::setOptions(['isRemoteEnabled' => true, 'dpi' => 150])
            ->loadView('pages.presence.detail.export-pdf', compact('presence', 'presenceDetails', 'exportDate')) // Kirim $exportDate
            ->setPaper('a4', 'landscape');

        $fileName = Str::slug($presence->nama_kegiatan . '-absensi-' . Carbon::parse($exportDate)->format('Y-m-d')) . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * Menghapus data absensi peserta tertentu.
     * $id adalah ID dari PresenceDetail.
     */
    public function destroy($id)
    {
        $presenceDetail = PresenceDetail::findOrFail($id);

        if ($presenceDetail->tanda_tangan) {
            // 'public_uploads' adalah nama disk di config/filesystems.php
            // $presenceDetail->tanda_tangan harus menyimpan path relatif, contoh: 'tanda-tangan/file.png'
            if (Storage::disk('public_uploads')->exists($presenceDetail->tanda_tangan)) {
                Storage::disk('public_uploads')->delete($presenceDetail->tanda_tangan);
            }
        }
        $presenceDetail->delete();
        return redirect()->back()->with('success', 'Data absensi peserta berhasil dihapus.');
    }
}