<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grade;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function index()
    {
        return view('main.admin.index');
    }

    public function get_data_admin()
    {
        $data = User::with('group')
            ->whereHas('group', function ($group) {
                return $group->where('name', 'admin');
            })
            ->get();

        return response()->json([
            'data'      => $data,
            'status'    => 200
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'              => ['file', 'mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            'name'              => ['required'],
            'email'             => ['required', 'email', 'unique:tbl_users,email'],
            'password'          => ['required', 'min:8'],
            'passwordConfirm'   => ['required', 'same:password']
        ], [
            'file.file'                    => 'Foto harus di isi!',
            'file.mimes'                   => 'Foto harus bertipe jpeg/png/jpg!',
            'file.max'                     => 'Ukuran Foto maximal 2 MB!',
            'name.required'                => 'Nama wajib di isi!',
            'email.required'               => 'Email wajib di isi!',
            'email.email'                  => 'Email tidak sesuai!',
            'email.unique'                 => 'Email sudah digunakan!',
            'password.required'            => 'Password wajib di isi!',
            'password.min'                 => 'Password minimal 8 karakter!',
            'passwordConfirm.required'     => 'Konfirmasi Password wajib di isi!',
            'passwordConfirm.same'         => 'Konfirmasi Password salah!',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = 'admin-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/avatars/'), $file_name);
        } else {
            $file_name = 'default.jpg';
        }

        User::insert([
            'group_id'      => 1,
            'grade_id'      => null,
            'name'          => $request->name,
            'email'         => $request->email,
            'photos'        => $file_name,
            'password'      => bcrypt($request->password),
            'created_at'    => date('Y-m-d'),
            'updated_at'    => date('Y-m-d')
        ]);

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'status'   => 200
        ]);
    }

    public function show($type = null, $id)
    {
        $data = User::find($id);

        $data = [
            'data'          => $data,
            'is_profile'    => $type == 'profile' ? true : false,
            'title'         => $type == 'profile' ? 'My Profile' : 'Detail Data Admin'
        ];

        return view('main.admin.show', $data);
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->with('grade')->first();

        return response()->json([
            'data'      => $data,
            'status'    => 200
        ]);
    }

    public function update(Request $request)
    {
        $data_old = User::find($request->id);

        $request->email == $data_old['email'] ? $validate_is_unique = '' : $validate_is_unique = 'unique:tbl_users,email';
        $request->password == '' ? $validate_password = '' : $validate_password = 'min:8';

        $request->validate([
            'file'              => ['max:2048'],
            'name'              => ['required'],
            'email'             => ['required', 'email', $validate_is_unique],
            'password'          => [$validate_password],
            'passwordConfirm'   => ['same:password']
        ], [
            'file.max'                     => 'Ukuran Foto maximal 2 MB!',
            'name.required'                => 'Nama wajib di isi!',
            'email.required'               => 'Email wajib di isi!',
            'email.email'                  => 'Email tidak sesuai!',
            'email.unique'                 => 'Email sudah digunakan!',
            'password.min'                 => 'Password minimal 8 karakter!',
            'passwordConfirm.same'         => 'Konfirmasi Password salah!',
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = 'admin-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            if ($data_old['photos'] != 'default.png' && $data_old['photos'] != 'default-2.jpg' && $data_old['photos'] != 'default-3.jpg') {
                unlink(public_path('assets/img/avatars/' . $data_old['photos']));
            }

            $file->move(public_path('assets/img/avatars/'), $file_name);
        } else {
            $file_name = $data_old['photos'];
        }

        User::where('id', $request->id)->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'photos'        => $file_name,
            'updated_at'    => date('Y-m-d')
        ]);

        if ($request->password != '') {
            User::where('id', $request->id)->update([
                'password' => bcrypt($request->password)
            ]);
        }

        return response()->json([
            'message'   => 'Berhasil update data!',
            'status'    => 200
        ]);
    }

    public function destroy($id)
    {
        $data_old = User::find($id);

        User::destroy($id);

        if ($data_old['photos'] != 'default.png' && $data_old['photos'] != 'default-2.jpg' && $data_old['photos'] != 'default-3.jpg') {
            unlink(public_path('assets/img/avatars/' . $data_old['photos']));
        }

        return response()->json([
            'message'   => 'Berhasil hapus data!',
            'status'    => 200
        ]);
    }
}
