<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grade;
use Illuminate\Support\Str;

class TcgController extends Controller
{

    public function index()
    {
        return view('main.admin.tcg.index');
    }

    public function get_data_users()
    {
        $data = User::with('grade', 'group')
            ->whereHas('group', function ($group) {
                return $group->where('name', 'users');
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
            'file'      => ['file', 'mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            'name'      => ['required'],
            'email'     => ['required', 'email', 'unique:tbl_users,email'],
            'x'         => ['required', 'numeric', 'between:1,33'],
            'y'         => ['required', 'numeric', 'between:1,23'],
            'z'         => ['required', 'numeric', 'between:1,18'],
            'w'         => ['required', 'numeric', 'between:1,13'],
        ], [
            'file.file'         => 'Foto harus di isi!',
            'file.mimes'        => 'Foto harus bertipe jpeg/png/jpg!',
            'file.max'          => 'Ukuran Foto maximal 2 MB!',
            'name.required'     => 'Nama wajib di isi!',
            'email.required'    => 'Email wajib di isi!',
            'email.email'       => 'Email tidak sesuai!',
            'email.unique'      => 'Email sudah digunakan!',
            'x.required'        => 'Nilai X wajib di isi!',
            'x.numeric'         => 'Nilai X harus berupa angka!',
            'x.between'         => 'Nilai X harus 1-33!',
            'y.required'        => 'Nilai Y wajib di isi!',
            'y.numeric'         => 'Nilai Y harus berupa angka!',
            'y.between'         => 'Nilai Y harus 1-23!',
            'z.required'        => 'Nilai Z wajib di isi!',
            'z.numeric'         => 'Nilai Z harus berupa angka!',
            'z.between'         => 'Nilai Z harus 1-18!',
            'w.required'        => 'Nilai W wajib di isi!',
            'w.numeric'         => 'Nilai W harus berupa angka!',
            'w.between'         => 'Nilai W harus 1-13!',
        ]);

        $grade              = new Grade();
        $grade->x           = $request->x;
        $grade->y           = $request->y;
        $grade->z           = $request->z;
        $grade->w           = $request->w;
        $grade->save();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = 'peserta-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/avatars/'), $file_name);
        } else {
            $file_name = 'default.jpg';
        }

        User::insert([
            'group_id'      => 2,
            'grade_id'      => $grade->id,
            'name'          => $request->name,
            'email'         => $request->email,
            'photos'        => $file_name,
            'password'      => null,
            'created_at'    => date('Y-m-d'),
            'updated_at'    => date('Y-m-d')
        ]);

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'status'   => 200
        ]);
    }

    public function show($id)
    {
        $data = User::where('id', $id)->with('grade')->first();

        $x = $data->grade['x'] * 0.4;
        $y = $data->grade['y'] * 0.6;
        $result_intelegensi = (($x + $y) / 2);

        $z = $data->grade['z'] * 0.3;
        $w = $data->grade['w'] * 0.7;
        $result_numerical_ability = (($z + $w) / 2);

        $data = [
            'data'                          => $data,
            'result_intelegensi'            => $result_intelegensi,
            'result_numerical_ability'      => $result_numerical_ability,
        ];

        return view('main.peserta.show', $data);
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

        $request->validate([
            'file'      => ['max:2048'],
            'name'      => ['required'],
            'email'     => ['required', 'email', $validate_is_unique],
            'x'         => ['required', 'numeric', 'between:1,33'],
            'y'         => ['required', 'numeric', 'between:1,23'],
            'z'         => ['required', 'numeric', 'between:1,18'],
            'w'         => ['required', 'numeric', 'between:1,13'],
        ], [
            'file.max'          => 'Ukuran Foto maximal 2 MB!',
            'name.required'     => 'Nama wajib di isi!',
            'email.required'    => 'Email wajib di isi!',
            'email.email'       => 'Email tidak sesuai!',
            'email.unique'      => 'Email sudah digunakan!',
            'x.required'        => 'Nilai X wajib di isi!',
            'x.numeric'         => 'Nilai X harus berupa angka!',
            'x.between'         => 'Nilai X harus 1-33!',
            'y.required'        => 'Nilai Y wajib di isi!',
            'y.numeric'         => 'Nilai Y harus berupa angka!',
            'y.between'         => 'Nilai Y harus 1-23!',
            'z.required'        => 'Nilai Z wajib di isi!',
            'z.numeric'         => 'Nilai Z harus berupa angka!',
            'z.between'         => 'Nilai Z harus 1-18!',
            'w.required'        => 'Nilai W wajib di isi!',
            'w.numeric'         => 'Nilai W harus berupa angka!',
            'w.between'         => 'Nilai W harus 1-13!',
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = 'peserta-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

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

        Grade::where('id', $data_old['grade_id'])->update([
            'x'             => $request->x,
            'y'             => $request->y,
            'z'             => $request->z,
            'w'             => $request->w,
            'updated_at'    => date('Y-m-d')
        ]);

        return response()->json([
            'message'   => 'Berhasil update data!',
            'status'    => 200
        ]);
    }

    public function destroy($id)
    {
        $data_old = User::find($id);

        User::destroy($id);
        Grade::destroy($data_old['grade_id']);

        if ($data_old['photos'] != 'default.png' && $data_old['photos'] != 'default-2.jpg' && $data_old['photos'] != 'default-3.jpg') {
            unlink(public_path('assets/img/avatars/' . $data_old['photos']));
        }

        return response()->json([
            'message'   => 'Berhasil hapus data!',
            'status'    => 200
        ]);
    }
}
