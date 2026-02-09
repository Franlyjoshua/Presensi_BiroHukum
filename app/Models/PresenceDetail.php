<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceDetail extends Model
{
    use HasFactory;

    // Pastikan semua kolom yang di-input di Controller ada di sini
    protected $fillable = [
        'presence_id',
        'tanggal_absensi',
        'nama',
        'email',
        'no_hp',
        'instansi',
        'identity_number',
        'identity_type',
        'nama_bank',
        'no_rekening',
        'atas_nama',
        'npwp',
        'golongan',
        'tanda_tangan'
    ];

    // Casting tanggal agar bisa diformat dengan mudah di View (Carbon)
    protected $casts = [
        'tanggal_absensi' => 'date',
    ];

    /**
     * Relasi ke tabel Presence (Kegiatan).
     * Ini PENTING agar di halaman 'Terima Kasih' kita bisa memanggil:
     * $item->presence->title (untuk menampilkan nama kegiatannya)
     */
    public function presence()
    {
        return $this->belongsTo(Presence::class, 'presence_id');
    }
}