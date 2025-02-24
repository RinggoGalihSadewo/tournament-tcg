<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Registration;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.tournament.index');
    }

    public function get_data_tournament()
    {
        $data = Tournament::all();

        return response()->json([
            'data'      => $data,
            'status'    => 200
        ]);
    }

    public function view_tournament_client()
    {   
        $tournaments_all = Tournament::all();
        $tournaments = Tournament::where('status_tournament', 'active')->with('registration')->get();

        return view('main.client.tournament.index', compact('tournaments_all'), compact('tournaments'));
    }

    public function view_my_events_client()
    {
        $id_user = Auth::user()->id_user;
    
        $tournaments = Tournament::where('status_tournament', 'active')
            ->whereHas('registration', function($query) use ($id_user) {
                $query->where('id_user', $id_user);
            })
            ->with('registration') 
            ->get();
    
        return view('main.client.my-event.index', compact('tournaments'));
    }
    
    public function search_tournament(Request $request)
    {
        $search = $request->search;

        $tournaments_all = Tournament::all();
        
        if($search !== ''){
            $tournaments = Tournament::where('status_tournament', 'active')
            ->where('name_tournament', 'like', '%' . $search . '%') // Menambahkan pencarian berdasarkan nama
            ->with('registration') // Tetap load relasi 'registration'
            ->get();
        }else {
            $tournaments = Tournament::where('status_tournament', 'active')->with('registration')->get();
        }
    
        // return view('main.client.tournament.index', compact('tournaments_all'), compact('tournaments'));
        return response()->json([
            'data'      => $tournaments,
            'status'    => 200
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main.admin.tournament.show', [
            'title' => 'Create Tournament'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'file'              => ['file', 'mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            'name_tournament'              => ['required'],
            'date_tournament'             => ['required'],
            'description_tournament'             => ['required'],
            'status_tournament'             => ['required'],

        ], [
            'file.file'                    => 'Foto harus di isi!',
            'file.mimes'                   => 'Foto harus bertipe jpeg/png/jpg!',
            'file.max'                     => 'Ukuran Foto maximal 2 MB!',
            'name_tournament.required'                => 'Name wajib di isi!',
            'date_tournament.required'               => 'Tanggal Tournament wajib di isi!',
            'description_tournament.required'               => 'Description Tournament wajib di isi!',
            'status_tournament.required'               => 'Status Tournament wajib di isi!',

        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = 'tournament-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/tournament/'), $file_name);
        } else {
            $file_name = 'no-image.jpg';
        }

        Tournament::insert([
            'name_tournament'     => $request->name_tournament,
            'date_tournament'     => Carbon::createFromFormat('m/d/Y', $request->date_tournament)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            'description_tournament'        => $request->description_tournament,
            'status_tournament'        => $request->status_tournament,
            'photo_tournament'          => $file_name,
            'created_at'               =>  date('Y-m-d'),
            'updated_at'                => date('Y-m-d')
        ]);

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'status'   => 200,
            'redirect' => '/admin/tournament'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Tournament::where('id_tournament', $id)->first();
        $type = 'detail';

        return view('main.admin.tournament.show', [
            'title' => 'Detail Tournament',
            'data'  => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Tournament::where('id_tournament', $id)->first();
        $type = 'Edit';

        return view('main.admin.tournament.show', [
            'title' => 'Edit Tournament',
            'data'  => $data
        ]);    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $data_old = Tournament::find($request->id);

        $request->validate([
            // 'file'              => ['mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            'name_tournament'              => ['required'],
            'date_tournament'             => ['required'],
            'description_tournament'             => ['required'],
            'status_tournament'             => ['required'],

        ], [
            // 'file.file'                    => 'Foto harus di isi!',
            // 'file.mimes'                   => 'Foto harus bertipe jpeg/png/jpg!',
            // 'file.max'                     => 'Ukuran Foto maximal 2 MB!',
            'name_tournament.required'                => 'Name wajib di isi!',
            'date_tournament.required'               => 'Tanggal Tournament wajib di isi!',
            'description_tournament.required'               => 'Description Tournament wajib di isi!',
            'status_tournament.required'               => 'Status Tournament wajib di isi!',

        ]);    

        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = 'tournament-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            if ($data_old['photo_tournament'] != 'no-image.jpg') {
                unlink(public_path('assets/img/tournament/' . $data_old['photo_tournament']));
            }

            $file->move(public_path('assets/img/tournament/'), $file_name);
        } else {
            $file_name = $data_old['photo_tournament'];
        }

        Tournament::where('id_tournament', $request->id)->update([
            'name_tournament'     => $request->name_tournament,
            'date_tournament'     => Carbon::createFromFormat('m/d/Y', $request->date_tournament)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            'description_tournament'        => $request->description_tournament,
            'status_tournament'        => $request->status_tournament,
            'photo_tournament'          => $file_name,
            'updated_at'    => date('Y-m-d')
        ]);

        return response()->json([
            'message'   => 'Berhasil update data!',
            'status'    => 200,
            'redirect'  => '/admin/tournament'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data_old = Tournament::find($id);

        if ($data_old['photo_tournament'] != 'no-image.jpg') {
            // unlink(public_path('assets/img/tournament/' . $data_old['photo_tournament']));
        }
        
        Registration::where('id_tournament', $id)->delete();

        Tournament::where('id_tournament', $id)->delete();

        return response()->json([
            'message'   => 'Berhasil hapus data!',
            'status'    => 200
        ]);    }
}
