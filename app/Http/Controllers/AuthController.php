<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function registration()
    {
        return view('auth.registration');
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

        $data = User::where('email', $request->email)->first();

        if ($data) {
            if (Auth::attempt($credentials)) {
                if ($data->is_admin) {
                    $request->session()->regenerate();

                    return response()->json([
                        'message'   => 'Berhasil Login!',
                        'status'    => 200,
                        'redirect'  => url('/admin/tcg')
                    ]);
                }
                return response()->json([
                    'message'   => 'Berhasil Login!',
                    'status'    => 200,
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

    public function createRegistration(Request $request)
    {
        $request->validate([
            'file'              => ['file', 'mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            'username'              => ['required'],
            'name'              => ['required'],
            'email'             => ['required', 'email', 'unique:user,email'],
            'password'          => ['required', 'min:8'],
            'phone_number'          => ['required'],
        ], [
            'file.file'                    => 'Foto harus di isi!',
            'file.mimes'                   => 'Foto harus bertipe jpeg/png/jpg!',
            'file.max'                     => 'Ukuran Foto maximal 2 MB!',
            'username.required'            => 'Username wajib di isi!',
            'name.required'                => 'Name wajib di isi!',
            'email.required'               => 'Email wajib di isi!',
            'email.email'                  => 'Email tidak sesuai!',
            'email.unique'                 => 'Email sudah digunakan!',
            'password.required'            => 'Password wajib di isi!',
            'password.min'                 => 'Password minimal 8 karakter!',
            'phone_number.required'        => 'Phone number wajib di isi!'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = 'admin-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/profile/'), $file_name);
        } else {
            $file_name = 'default.jpg';
        }

        User::insert([
            'username'      => $request->username,
            'name'         => $request->name,
            'email'         => $request->email,
            'photo'         => $file_name,
            'password'      => bcrypt($request->password),
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'is_admin'      => true,
            'created_at'    => date('Y-m-d'),
            'updated_at'    => date('Y-m-d')
        ]);

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'status'   => 200,
            'redirect' => '/login'
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
