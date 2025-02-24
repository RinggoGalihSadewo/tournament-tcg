<?php

namespace App\Http\Controllers;

use App\Models\Tcg;
use App\Models\User;
use App\Models\Decklog;
use App\Models\Tournament;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Carbon\Carbon;

class DeckLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = Auth::user()->username;

        $tcgs = Tcg::all();
        $decklogs = Decklog::all();

        foreach ($tcgs as $tcg) {
            $filteredDecklogs = $decklogs->where('id_tcg', $tcg->id_tcg)
                ->where('username', $username) 
                ->sortByDesc('created_at') 
                ->values(); 

            $tcg->decklog = $filteredDecklogs;
        }
    
        return view('main.client.deck-log.index', compact('tcgs'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_user = Auth::user()->id_user;
        $user = User::find($id_user);

        $request->validate([
            // 'file'      => ['file', 'mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            // 'name'      => ['required'],
        ], [
            // 'file.file'         => 'Foto harus di isi!',
            // 'file.mimes'        => 'Foto harus bertipe jpeg/png/jpg!',
            // 'file.max'          => 'Ukuran Foto maximal 2 MB!',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = 'deck-log-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/deckLog/'), $file_name);
        } else {
            $file_name = 'no-image.jpg';
        }

        if($user){
            Decklog::insert([
                'username'      => $user->username,
                'id_tcg'        => $request->id_tcg,
                'photo'         => $file_name,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
        }

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'redirect' => '/deck-log',
            'status'   => 200,
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data_old = Decklog::where('id_tcg', $id)->first();

        // if ($data_old && $data_old->photo != 'no-image.jpg') {
        //     unlink(public_path('assets/img/deckLog/' . $data_old->photo));
        // }
        
        Decklog::where('id_tcg', $id)->delete();
        
        return response()->json([
            'message'   => 'Berhasil hapus data!',
            'redirect'  => '/deck-log',
            'status'    => 200
        ]);
          
    }
}
