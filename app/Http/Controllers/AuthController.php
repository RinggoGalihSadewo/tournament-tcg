<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required', 'min:8'],
        ], [
            'email.required'    => 'Email wajib di isi!',
            'email.email'       => 'Email tidak sesuai!',
            'password.required' => 'Password wajib di isi!',
            'password.min'      => 'Password minimal 8 karakter!',
        ]);

        $data = User::where('email', $request->email)->with('group')->first();

        if ($data) {
            if (Auth::attempt($credentials)) {
                if ($data->group['name'] == 'admin') {
                    $request->session()->regenerate();

                    return response()->json([
                        'message'   => 'Berhasil Login!',
                        'status'    => 200,
                        'redirect'  => url('/data-peserta')
                    ]);
                }
                return response()->json([
                    'message'   => 'Anda bukan Admin!',
                    'status'    => 401,
                    'redirect'  => url('/')
                ]);
            } else {
                return response()->json([
                    'message'   => 'Username atau Password salah!',
                    'status'    => 401,
                    'redirect'  => url('/')
                ]);
            }
        }

        return response()->json([
            'message'   => 'Akun tidak terdaftar!',
            'status'    => 401,
            'redirect'  => url('/')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message'   => 'Berhasil Logout!',
            'status'    => 200,
            'redirect'  => url('/')
        ]);
    }
}
