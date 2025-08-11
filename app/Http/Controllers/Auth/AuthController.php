<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Sign In';

        return view('auth.pages.sign-in.index', compact('title'));
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Email tidak ditemukan
            return back()->withErrors([
                'email' => 'This email is not registered!'
            ])->withInput();
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            // Password salah
            return back()->withErrors([
                'password' => 'Incorrect password. Please try again!'
            ])->withInput();
        }

        // Login jika email & password cocok
        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'cashier') {
            return redirect()->intended('/cashier/dashboard');
        } elseif ($user->role === 'owner') {
            return redirect()->intended('/owner/dashboard');
        } else {
            return redirect()->intended('/');
        }
    }

    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/sign-in');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan email, kalau belum ada buat baru
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(16)), // password random
                    'role' => 'customer', // default role
                ]
            );

            Auth::login($user);

            // Redirect sesuai role
            if ($user->role === 'cashier') {
                return redirect('/cashier/dashboard');
            } elseif ($user->role === 'owner') {
                return redirect('/owner/dashboard');
            }

            return redirect('/');

        } catch (\Exception $e) {
            return redirect('/auth/sign-in')->withErrors(['google' => 'Login Google gagal']);
        }
    }
}
