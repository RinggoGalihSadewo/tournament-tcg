<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registration;
use App\Models\Tournament;
use App\Models\Ranking;

use Illuminate\Support\Str;

class TournamentParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournaments = Tournament::all();

        return view('main.admin.tournament.participant.index', compact('tournaments'));
    }

    public function pairing_view(){

        $participants = User::where('is_admin', false)
                        ->whereHas('registration', function ($query) {
                            $query->whereHas('tournament');
                        })
                        ->with(['registration' => function ($query) {
                            $query->with('tournament');
                        }])
                        ->get();

        $tournaments = Tournament::all();

        return view('main.admin.tournament.participant.pairing', [
            'title' => 'Pairing Participants',
            'participants' => $participants,
            'tournaments' => $tournaments
        ]);
    }

    public function get_data_tournament_participant() 
    {
        $data = User::where('is_admin', false)
                    ->whereHas('registration', function ($query) {
                        $query->whereHas('tournament');
                    })
                    ->with(['registration' => function ($query) {
                        $query->with('tournament');
                    }])
                    ->get();
    
        return response()->json([
            'data'   => $data,
            'status' => 200
        ]);
    }

    public function get_participant_by_tournament(Request $request) 
    {
        $id_tournament = $request->id_tournament; // Ambil ID dari request
    
        $data = User::where('is_admin', false)
                    ->whereHas('registration', function ($query) use ($id_tournament) {
                        $query->whereHas('tournament', function ($q) use ($id_tournament) {
                            $q->where('id_tournament', $id_tournament); // Filter berdasarkan ID turnamen
                        });
                    })
                    ->with(['registration' => function ($query) use ($id_tournament) {
                        $query->whereHas('tournament', function ($q) use ($id_tournament) {
                            $q->where('id_tournament', $id_tournament); // Pastikan hanya mengambil registrasi turnamen ini
                        })->with('tournament');
                    }])
                    ->get();
    
        return response()->json([
            'data'   => $data,
            'status' => 200
        ]);
    }

    public function save_pairing(Request $request)
    {
        $participants = $request->participants;
        $participants = json_decode($request->participants, true);
        $id_tournament = $request->id_tournament;
    
        if (is_array($participants) && count($participants) > 0) {
    
            for ($i = 0; $i < count($participants); $i++) {
    
                $user = User::where('name', $participants[$i]['name'])->first(); 
    
                if ($user) {
                    Ranking::insert([
                        'poin'                       => $participants[$i]['points'],
                        'id_tournament'              => $id_tournament,
                        'id_user'                    => $user->id_user,
                        'created_at'                 => date('Y-m-d'),
                        'updated_at'                 => date('Y-m-d')
                    ]);
                }
            }
    
            return response()->json([
                'message'  => 'Tambah Data Berhasil',
                'status'   => 200,
                'redirect' => '/admin/tournament-participants'
            ]);
        }
    
        return response()->json([
            'message' => 'Data tidak valid',
            'status'  => 400
        ]);
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            // 'file'              => ['file', 'mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            'email'             => ['required'],
            'username'              => ['required'],
            'name'              => ['required'],
            'password'          => ['required', 'min:8'],
            'phone_number'          => ['required'],
            'tournament'          => ['required','exists:tournament,id_tournament'],
        ], [
            // 'file.file'                    => 'Foto harus di isi!',
            // 'file.mimes'                   => 'Foto harus bertipe jpeg/png/jpg!',
            // 'file.max'                     => 'Ukuran Foto maximal 2 MB!',
            'email.required'               => 'Email wajib di isi!',
            'username.required'            => 'Username wajib di isi!',
            'name.required'                => 'Name wajib di isi!',
            'email.required'               => 'Email wajib di isi!',
            'password.required'            => 'Password wajib di isi!',
            'password.min'                 => 'Password minimal 8 karakter!',
            'phone_number.required'        => 'Phone number wajib di isi!',
            'tournament.required'          => 'Tournament wajib di isi!',
            'tournament.exists'            => 'Tournament tidak valid!',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = 'player-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/profile/'), $file_name);
        } else {
            $file_name = 'default.jpg';
        }

        $user_id = User::insertGetId([
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

        Registration::insert([
            'username'                   => $request->username,
            'status_payment'             => $request->status_payment,
            'date_registration'          => date('Y-m-d'),
            'id_tournament'              => $request->tournament,
            'id_user'                    => $user_id,
            'created_at'                 => date('Y-m-d'),
            'updated_at'                 => date('Y-m-d')
        ]);

        return response()->json([
            'message'  => 'Tambah Data Berhasil',
            'status'   => 200,
            'redirect' => '/login'
        ]);
    }

    public function regis_tournament_client(Request $request)
    {
        Registration::insert([
            'username'                   => $request->username,
            'date_registration'          => date('Y-m-d'),
            'id_tournament'              => $request->id_tournament,
            'id_user'                    => $request->id_user,
            'created_at'                 => date('Y-m-d'),
            'updated_at'                 => date('Y-m-d')
        ]);

        return response()->json([
            'message'  => 'Berhasil Regis!',
            'status'   => 200,
            'redirect' => '/tournaments'
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

        $data = User::where('id_tcg', $id)
                ->whereHas('registration', function ($query) {
                    $query->whereHas('tournament');
                })
                ->with(['registration' => function ($query) {
                    $query->with('tournament');
                }])
                ->first();

        $data = [
            'title' => 'Detail Tournament Participant',
            'is_profile' => true,
            'data' => $data,
        ];

        return view('main.admin.tournament.participant.show', $data);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::where('id_user', $id)
                ->whereHas('registration', function ($query) {
                    $query->whereHas('tournament');
                })
                ->with(['registration' => function ($query) {
                    $query->with('tournament');
                }])
                ->first();

        return response()->json([
            'data'      => $data,
            'status'    => 200
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data_old = User::find($request->id);

        $request->validate([
            // 'file'              => ['file', 'mimes:jpeg,png,jpg,JPEG,PNG,JPG', 'max:2048'],
            'email'              => ['required'],
            'username'              => ['required'],
            'name'              => ['required'],
            'email'             => ['required'],
            'password'          => ['required', 'min:8'],
            'phone_number'          => ['required'],
            'tournament'          => ['required','exists:tournament,id_tournament'],
            'status_payment'              => ['required'],
        ], [
            // 'file.file'                    => 'Foto harus di isi!',
            // 'file.mimes'                   => 'Foto harus bertipe jpeg/png/jpg!',
            // 'file.max'                     => 'Ukuran Foto maximal 2 MB!',
            'email.required'               => 'Email wajib di isi!',
            'username.required'            => 'Username wajib di isi!',
            'name.required'                => 'Name wajib di isi!',
            'email.required'               => 'Email wajib di isi!',
            'password.required'            => 'Password wajib di isi!',
            'password.min'                 => 'Password minimal 8 karakter!',
            'phone_number.required'        => 'Phone number wajib di isi!',
            'tournament.required'          => 'Tournament wajib di isi!',
            'tournament.exists'            => 'Tournament tidak valid!',
            'status_payment.required'      => 'Status payment wajib di isi!',
        ]);


        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = 'player-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            if ($data_old['photo'] != 'no-image.png') {
                unlink(public_path('assets/img/profile/' . $data_old['photo']));
            }

            $file->move(public_path('assets/img/profile/'), $file_name);
        } else {
            $file_name = $data_old['photo'];
        }

        User::where('id_user', $request->id)->update([
            'username'          => $request->username,
            'name'              => $request->name,
            // 'email'          => $request->email,
            'photo'             => $file_name,
            // 'password'       => bcrypt($request->password),
            'phone_number'      => $request->phone_number,
            'address'           => $request->address,
            'updated_at'        => date('Y-m-d')
        ]);

        Registration::where('id_user', $request->id)->update([
            'username'                   => $request->username,
            'status_payment'             => $request->status_payment,
            'id_tournament'              => $request->tournament,
            'updated_at'                 => date('Y-m-d')
        ]);

        return response()->json([
            'message'   => 'Berhasil update data!',
            'status'    => 200
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
        $data_old = User::find($id);

        if ($data_old['photo'] != 'no-image.png') {
            unlink(public_path('assets/img/profile/' . $data_old['photo']));
        }
        
        Registration::where('id_user', $id)->delete();
        User::destroy($id);

        return response()->json([
            'message'   => 'Berhasil hapus data!',
            'status'    => 200
        ]);
    }
}
