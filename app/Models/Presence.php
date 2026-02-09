<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Pastikan Carbon di-import

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'slug',
        'datetime_mulai',
        'datetime_selesai',
        'is_link_active',
    ];

    // Bagian ini sudah benar
    protected $casts = [
        'datetime_mulai' => 'datetime',
        'datetime_selesai' => 'datetime',
        'is_link_active' => 'boolean',
    ];

    public function presenceDetails()
    {
        return $this->hasMany(PresenceDetail::class);
    }

    /**
     * Method untuk mendapatkan semua kemungkinan tanggal absensi dari sebuah kegiatan.
     * @return array
     */
    public function getAvailableDates(): array
    {
        $dates = [];
        $start = Carbon::parse($this->datetime_mulai)->startOfDay();

        // --- INI PERBAIKANNYA ---
        // Kita tidak menggunakan startOfDay() pada tanggal selesai agar rentangnya benar
        $end = Carbon::parse($this->datetime_selesai);

        // Loop dari awal hingga akhir, tambahkan setiap tanggal ke array
        while ($start->lte($end)) {
            $dates[] = $start->toDateString();
            $start->addDay();
        }
        return $dates;
    }
}
