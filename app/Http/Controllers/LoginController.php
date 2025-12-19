<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //  Proses login manual (email & password)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Arahkan sesuai role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard.admin');
                case 'akademik':
                    return redirect()->route('dashboard.akademik');
                case 'dosen':
                    return redirect()->route('dashboard.dosen');
                case 'kaprodi':
                    return redirect()->route('dashboard.kaprodi');
                case 'wadir1':
                    return redirect()->route('dashboard.wadir1');
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['role' => 'Role tidak dikenali.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    //  Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $email = $googleUser->getEmail();

        $allowedDomains = ['politala.ac.id', 'mhs.politala.ac.id'];
        $domain = substr(strrchr($email, "@"), 1);

        if (!in_array($domain, $allowedDomains)) {
            return redirect()->route('login')->withErrors([
                'msg' => 'Login hanya diperbolehkan dengan akun @politala.ac.id atau @mhs.politala.ac.id.'
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'msg' => 'Akun ini belum terdaftar di sistem.'
            ]);
        }

        if (empty($user->google_id)) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        Auth::login($user, true); // remember login

        switch ($user->role) {
            case 'admin': return redirect()->route('dashboard.admin');
            case 'akademik': return redirect()->route('dashboard.akademik');
            case 'dosen': return redirect()->route('dashboard.dosen');
            case 'kaprodi': return redirect()->route('dashboard.kaprodi');
            case 'wadir1': return redirect()->route('dashboard.wadir1');
            default: return redirect()->route('dashboard.admin');
        }

    } catch (\Throwable $e) {
        return redirect()->route('login')->withErrors([
            'msg' => 'Login Google gagal.'
        ]);
    }
}

}
