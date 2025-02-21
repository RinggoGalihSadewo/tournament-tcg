<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Registration;

use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function view_login_client()
    {
        return view('main.client.auth.login');
    }

    public function view_my_profile_client()
    {
        $id_user = Auth::user()->id_user;

        $user = User::find($id_user);

        return view('main.client.my-profile.index', compact('user'));
    }

    public function view_registration_client()
    {
        return view('main.client.auth.registration');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ], [
            'email.required'    => 'Email wajib di isi!',
            'email.email'       => 'Email tidak sesuai!',
            'password.required' => 'Password wajib di isi!',
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
                }else {
                    $request->session()->put('user', $data);
                    $request->session()->regenerate();
                    // dd(session('user'));

                    return response()->json([
                        'message'   => 'Berhasil Login!',
                        'status'    => 200,
                        'redirect'  => url('/')
                    ]);
                }
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

    public function create_registration(Request $request)
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
            'redirect' => '/login-admin'
        ]);
    }

    public function create_registration_client(Request $request)
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
            $file_name = 'client-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/profile/'), $file_name);
        } else {
            $file_name = 'default.jpg';
        }

        User::insert([
            'username'      => $request->username,
            'name'          => $request->name,
            'email'         => $request->email,
            'photo'         => $file_name,
            'password'      => bcrypt($request->password),
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'is_admin'      => false,
            'created_at'    => date('Y-m-d'),
            'updated_at'    => date('Y-m-d')
        ]);

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'status'   => 200,
            'redirect' => '/login'
        ]);
    }

    public function update_my_profile_client(Request $request)
    {
        $data_old = User::find($request->id_user);

        $request->validate([
            'username'              => ['required'],
            'name'              => ['required'],
            'email'             => ['required', 'email'],
            'phone_number'          => ['required'],
        ], [
            'username.required'            => 'Username wajib di isi!',
            'name.required'                => 'Name wajib di isi!',
            'email.required'               => 'Email wajib di isi!',
            'email.email'                  => 'Email tidak sesuai!',
            'phone_number.required'        => 'Phone number wajib di isi!'
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = 'player-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            if ($data_old['photo'] != 'default.jpg') {
                unlink(public_path('assets/img/profile/' . $data_old['photo']));
            }

            $file->move(public_path('assets/img/profile/'), $file_name);
        } else {
            $file_name = $data_old['photo'];
        }

        $password = $request->password ? bcrypt($request->password) : $data_old->password;

        User::where('id_user', $request->id_user)->update([
            'username'      => $request->username,
            'name'          => $request->name,
            'email'         => $request->email,
            'photo'         => $file_name,
            'password'      => $password,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'updated_at'    => date('Y-m-d')
        ]);

        Registration::where('id_user', $request->id)->update([
            'username'                   => $request->username,
            'updated_at'                 => date('Y-m-d')
        ]);

        return response()->json([
            'message'   => 'Berhasil update data!',
            'redirect'  => '/my-profile',
            'status'    => 200,
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
