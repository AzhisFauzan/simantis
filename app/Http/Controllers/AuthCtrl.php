<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthCtrl extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'password' => 'required|max:20',
        ], [
            'name.required'     => 'Username tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.max'      => 'Password maksimal 20 karakter.',
        ]);

    $user = DB::table('users')
        ->whereRaw('BINARY name = ?', [$request->name])
        ->where('password', $request->password)
        ->first();

    if (!$user) {
        return back()
            ->withErrors(['login_error' => 'Username atau Password salah!'])
            ->withInput();
    }

    // Jika sama persis (ARUL dan ARUL), baru bisa login
    Auth::loginUsingId($user->id);

    return redirect('/dashboard')->with('pesan', 'Login Success');
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
