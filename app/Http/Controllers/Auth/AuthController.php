<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

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
            return redirect('/auth/sign-in')->withErrors(['google' => 'Google login failed!']);
        }
    }

    public function forgotPassword()
    {
        $title = 'Forgot Password';
        return view('auth.pages.forgot-password.index', compact('title'));
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Cek apakah email terdaftar di database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            session()->flash('error', 'We could not find a user with that email address.');
            return back(); // Redirect kembali jika email tidak ditemukan
        }

        // Membuat token reset password
        $token = Password::createToken($user);

        // Kirimkan email reset password menggunakan Mailable
        Mail::to($request->email)->send(new ResetPasswordMail($user, $token));

        session()->flash('status', 'Password reset link has been sent!');
        return back();
    }

    public function resetPasswordForm($token)
    {
        $title = 'Reset Password';

        // Cek apakah token sudah ada di tabel password_resets
        $resetPasswordEntry = DB::table('password_resets')->where('token', $token)->first();

        // Jika token sudah ada di password_resets (sudah digunakan)
        if ($resetPasswordEntry) {
            return view('auth.pages.reset-password.index', [
                'token' => $token,
                'error' => 'This reset token has already been used.'
            ]);
        }

        // Token valid, tampilkan form reset password
        return view('auth.pages.reset-password.index', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        // Mengecek apakah token sudah ada di tabel password_resets
        $resetEntry = DB::table('password_resets')->where('token', $request->token)->first();

        if ($resetEntry) {
            // Jika token sudah ada di password_resets, tampilkan error
            return back()->withErrors(['token' => 'This reset token has already been used.']);
        }

        // Melakukan reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = Hash::make($request->password); // Update password
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Simpan email dan token yang telah digunakan ke dalam tabel password_resets
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $request->token,
                'created_at' => now(),  // Simpan waktu reset
            ]);

            return redirect()->route('auth.sign-in')->with('status', 'Password successfully reset.');
        } else {
            return back()->withErrors(['email' => 'Failed to reset password.']);
        }
    }




}
