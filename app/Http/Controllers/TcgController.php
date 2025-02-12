<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tcg;
use App\Models\Grade;
use Illuminate\Support\Str;

class TcgController extends Controller
{

    public function index()
    {
        return view('main.admin.tcg.index');
    }

    public function get_data_tcg()
    {
        $data = Tcg::all();

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
        ], [
            'file.file'         => 'Foto harus di isi!',
            'file.mimes'        => 'Foto harus bertipe jpeg/png/jpg!',
            'file.max'          => 'Ukuran Foto maximal 2 MB!',
            'name.required'     => 'Nama wajib di isi!',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = 'tcg-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/tcg/'), $file_name);
        } else {
            $file_name = 'no-image.jpg';
        }

        Tcg::insert([
            'name_tcg'          => $request->name,
            'photo_tcg'         => $file_name,
        ]);

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'status'   => 200
        ]);
    }

    public function show($id)
    {
        $data = Tcg::where('id_tcg', $id)->first();

        $data = [
            'title' => 'Detail TCG',
            'is_profile' => true,
            'data' => $data,
        ];

        return view('main.admin.tcg.show', $data);
    }

    public function edit($id)
    {
        $data = Tcg::where('id_tcg', $id)->first();

        return response()->json([
            'data'      => $data,
            'status'    => 200
        ]);
    }

    public function update(Request $request)
    {
        $data_old = Tcg::find($request->id);

        $request->validate([
            'name'      => ['required'],
        ], [
            'name.required'     => 'Nama wajib di isi!',
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = 'tcg-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            if ($data_old['photo_tcg'] != 'no-image.png') {
                unlink(public_path('assets/img/tcg/' . $data_old['photo_tcg']));
            }

            $file->move(public_path('assets/img/tcg/'), $file_name);
        } else {
            $file_name = $data_old['photo_tcg'];
        }

        Tcg::where('id_tcg', $request->id)->update([
            'name_tcg'          => $request->name,
            'photo_tcg'     => $file_name,
            'updated_at'    => date('Y-m-d')
        ]);

        return response()->json([
            'message'   => 'Berhasil update data!',
            'status'    => 200
        ]);
    }

    public function destroy($id)
    {
        $data_old = Tcg::find($id);

        if ($data_old['photo_tcg'] != 'no-image.png') {
            unlink(public_path('assets/img/tcg/' . $data_old['photo_tcg']));
        }

        Tcg::destroy($id);

        return response()->json([
            'message'   => 'Berhasil hapus data!',
            'status'    => 200
        ]);
    }
}
