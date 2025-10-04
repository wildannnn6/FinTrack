<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Data tetap yang harus digunakan untuk login
    private $fixedData = [
        'email' => 'B123@gmail.com',
        'username' => 'Blair123',
        'password' => 'Blair123'
    ];

    public function index(){
        return view("halaman-login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf kecil, huruf besar, dan angka'
        ]);

        $username = $request->username;
        $email = $request->email;
        $password = $request->password;

        // Validasi terhadap data tetap
        if ($username !== $this->fixedData['username'] || $password !== $this->fixedData['password']) {
            return redirect()->route('login.index')
                ->withErrors(['login' => 'Akun tidak ditemukan, silahkan coba kembali'])
                ->withInput();
        }

        // Login berhasil
        session(['logged_in' => true, 'username' => $username]);
        return redirect()->route('home')->with('success', 'Login Berhasil! Selamat datang ' . $username);
    }
}