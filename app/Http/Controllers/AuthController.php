<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'npm' => 'required|string|max:50|unique:users,npm',
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'regex:/^[^@\s]+@student\.uir\.ac\.id$/i'],
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.regex' => 'Gunakan email student UIR dengan format nama@student.uir.ac.id.',
        ]);

        $user = User::create($data + ['role' => 'mahasiswa']);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Akun mahasiswa berhasil dibuat.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['login'])
            ->orWhere('npm', $credentials['login'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['login' => 'Email/NPM atau password tidak sesuai.'])
                ->onlyInput('login');
        }

        if ($user->role === 'tenaga_labor') {
            return back()
                ->withErrors(['login' => 'Akun laboran tidak dapat digunakan untuk login pada sistem ini.'])
                ->onlyInput('login');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar dari SILATS.');
    }
}
