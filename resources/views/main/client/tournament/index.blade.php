@extends('layout.client.master')

@section('title', 'Tournaments | WIN STREAX')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<section class="breadcumb-area bg-img bg-overlay" style="background-image: url({{asset('assets/img/client/bg-img/bg-1.jpg')}});">
    <div class="bradcumbContent">
        <p>See Tournaments</p>
        <h2>Tournaments</h2>
    </div>
</section>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Events Area Start ##### -->
<section class="events-area section-padding-100">
    <div class="container">
        <div class="row">
            <div class="col-12 mx-auto">
                <center>
                    <div>
                        {{-- <select class="form-control" id="tournament" name="tournament" placeholder="Tournament" style="width: 50%;">
                            <option value="" disabled selected>---Filter---</option> <!-- Filter pilihan default -->
                            @foreach($tournaments_all as $key => $tournament)
                                <option value="{{$tournament->id_tournament}}">{{ $tournament->name_tournament }}</option>
                            @endforeach
                        </select> --}}
                        <div style="row">
                            <div class="col-5">
                                <label for="search" class="sr-only">Search</label>
                                <input type="text" id="search" class="form-control form-control" name="search" placeholder="Search Tournament" required="" autofocus="">
                            </div>
                        </div>
                    </div>
                </center>
            </div>
        </div>
        <div class="row mt-4 d-flex justify-content-center" id="tournaments-container"> <!-- Tambahkan id pada container -->
            @foreach($tournaments as $tournament)
                <div class="col-12 col-md-6 col-lg-4 tournament-item" id="tournament-{{ $tournament->id_tournament }}"> <!-- Gunakan ID tournament sebagai bagian dari ID element -->
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="{{ asset('assets/img/tournament/' . $tournament->photo_tournament) }}" alt="" style="height: 400px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="event-text">
                            <h4>{{ $tournament->name_tournament }}</h4>
                            <div class="event-meta-data">
                                <p>{{ \Carbon\Carbon::parse($tournament->date_tournament)->format('F d, Y') }}</p>
                            </div>
                            <p>{{ $tournament->description_tournament }}</p>
                            
                            @if(session()->has('user'))
                                @php
                                    // Cek apakah user sudah terdaftar dalam relasi 'registration'
                                    $isRegistered = $tournament->registration->contains('id_user', Auth::user()->id_user);
                                @endphp
                
                                @if($isRegistered)
                                    <p>You are already registered for this tournament.</p>
                                @else
                                    <p class="btn see-more-btn" id="btnRegisTournament"
                                        data-id-user="{{ Auth::user()->id_user }}"
                                        data-username="{{ Auth::user()->username }}"
                                        data-id-tournament="{{ $tournament->id_tournament }}">
                                        Regis Tournament
                                    </p>
                                @endif
                            @else
                                <a href="/login" class="see-more-btn">Not logged in yet</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ##### Events Area End ##### -->

@endsection