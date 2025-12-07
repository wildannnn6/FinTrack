<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    // Mengarahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangani callback setelah user login di Google
    public function handleGoogleCallback()
    {
        try {
            // Mengambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $user = User::updateOrCreate(
                [
                    'email' => $googleUser->getEmail()
                ],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'password' => bcrypt('123456dummy'),
                    'user_type' => 'standard',
                ]
            );

            // Login user tersebut
            Auth::login($user);

            // Redirect ke dashboard atau halaman yang diinginkan
            return redirect()->route('home.standard');

        } catch (Exception $e) {
            // Jika error, kembalikan ke login dengan pesan error
            return redirect('login')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }
}