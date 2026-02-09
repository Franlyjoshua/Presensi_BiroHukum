<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PresenceDetailController;
use App\Http\Controllers\ParticipantLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\ChangePasswordController;

// Rute Beranda
Route::get('/', function () {
    return view('pages.index');
})->name('home');

// --- RUTE AUTENTIKASI ADMIN ---
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});

// --- RUTE AREA ADMIN (DIPROTEKSI) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => redirect()->route('admin.presence.index'))->name('dashboard');
    Route::resource('presence', PresenceController::class);
    Route::patch('presence/{id}/toggle-link', [PresenceController::class, 'toggleLinkStatus'])->name('presence.toggle-link');
    Route::delete('presence-detail/{id}', [PresenceDetailController::class, 'destroy'])->name('presence-detail.destroy');
    Route::get('presence-detail/export-pdf/{id}', [PresenceDetailController::class, 'exportPdf'])->name('presence-detail.export-pdf');

    // Rute Ganti Password
    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('password.update');
});


// ================================================================= //
// --- RUTE PUBLIK UNTUK PROSES ABSENSI ---
// ================================================================= //

Route::post('/absen/{presence}/save', [AbsenController::class, 'save'])->name('absen.save')->middleware('auth.participant');

// --- UPDATE RUTE TERIMA KASIH (Menangkap History) ---
Route::get('/absen/terima-kasih', function () {
    $continueUrl = session('continueUrl');
    $message = session('thank_you_message', 'Proses absensi selesai.');

    // Ambil data history dari session
    $history = session('history', []);

    // Hapus session
    session()->forget(['thank_you_message', 'continueUrl', 'history']);

    return view('pages.absen.thank_you', compact('message', 'continueUrl', 'history'));
})->name('absen.thankyou');


Route::prefix('absen/{slug}')->group(function () {
    Route::get('/register', [ParticipantLoginController::class, 'showDailyForm'])->name('participant.login.form.daily');
    Route::get('/register/multi', [ParticipantLoginController::class, 'showMultiDayForm'])->name('participant.login.form.multi');
    Route::post('/login', [ParticipantLoginController::class, 'login'])->name('participant.login.submit');
    Route::get('/', [AbsenController::class, 'index'])->name('absen.form')->middleware('auth.participant');
});

Route::get('/api/presence/{presence_slug}/available-dates/{nik}', [ParticipantLoginController::class, 'getAvailableDatesForNik'])->name('api.presence.get_available_dates');