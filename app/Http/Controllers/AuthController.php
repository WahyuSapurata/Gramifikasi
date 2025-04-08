<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function index()
    {
        $module = 'Login';
        return view('login.index', compact('module'));
    }

    public function login_proses(AuthRequest $authRequest)
    {
        $credential = $authRequest->getCredentials();
        $user = User::where('username', $authRequest->username)->first();

        if (!$user || !Auth::attempt($credential)) {
            return redirect()->route('login.login-akun')
                ->with('failed', 'Username atau Password salah')
                ->withInput($authRequest->only('username'));
        }

        // Jika autentikasi berhasil dan user terverifikasi
        return $this->authenticated();
    }

    public function authenticated()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard-admin');
        } elseif (auth()->user()->role === 'guru') {
            return redirect()->route('guru.dashboard-guru');
        } elseif (auth()->user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard-siswa');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.login-akun')->with('success', 'Berhasil Logout');
    }
}
