<?php

namespace App\Http\Middleware; // Pastikan namespace sesuai

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Presence; // Pastikan model Presence di-import
use Illuminate\Support\Facades\Log; // Penting untuk logging

class AuthenticateParticipant
{
    public function handle(Request $request, Closure $next): Response
    {
        // Logging awal untuk setiap request yang melewati middleware ini
        Log::info('AuthenticateParticipant Middleware Hit.', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'route_name' => optional($request->route())->getName(), // Gunakan optional() untuk safety
            'route_parameters' => optional($request->route())->parameters() // Gunakan optional()
        ]);

        // PERHATIAN: Nama session diubah agar konsisten dengan ParticipantLoginController
        $identityNumberInSession = $request->session()->get('identity_number');
        $authenticatedSlugInSession = $request->session()->get('presence_id') ? Presence::find($request->session()->get('presence_id'))->slug : null;
        
        $currentSlug = null;
        $presenceObjectFromRoute = $request->route('presence');
        $slugParamFromRoute = $request->route('slug');

        if ($presenceObjectFromRoute instanceof Presence) {
            $currentSlug = $presenceObjectFromRoute->slug;
        } elseif ($slugParamFromRoute) {
            $currentSlug = $slugParamFromRoute;
        }

        if (is_null($currentSlug)) {
            Log::error('AuthenticateParticipant: CRITICAL - Could not determine current slug for redirect.');
            return redirect()->route('home')->withErrors(['auth_error' => 'Parameter kegiatan tidak dapat diidentifikasi.']);
        }

        if (!$identityNumberInSession) {
            Log::info('AuthenticateParticipant: No NIK in session. Redirecting to login form.', ['target_slug' => $currentSlug]);
            // --- PERUBAHAN 1 ---
            // Mengarahkan ke rute login harian yang benar
            return redirect()->route('participant.login.form.daily', ['slug' => $currentSlug]) 
                ->withErrors(['auth' => 'Silakan masukkan NIK Anda untuk melanjutkan.']);
        }

        if ($authenticatedSlugInSession !== $currentSlug) {
            Log::info('AuthenticateParticipant: Authenticated slug mismatch. Redirecting to login form.', [
                'session_slug' => $authenticatedSlugInSession,
                'current_route_slug' => $currentSlug
            ]);
            // --- PERUBAHAN 2 ---
            // Mengarahkan ke rute login harian yang benar
            return redirect()->route('participant.login.form.daily', ['slug' => $currentSlug])
                ->with('info_message', 'Verifikasi NIK untuk kegiatan ini.');
        }

        Log::info('AuthenticateParticipant: Authentication passed for slug.', ['slug' => $currentSlug]);
        return $next($request);
    }
}