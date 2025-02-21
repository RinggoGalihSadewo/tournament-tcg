@extends('layout.client.master')

@section('title', 'My Events | WIN STREAX')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<section class="breadcumb-area bg-img bg-overlay" style="background-image: url({{asset('assets/img/client/bg-img/bg-1.jpg')}});">
    <div class="bradcumbContent">
        <p>See My Events</p>
        <h2>My Events</h2>
    </div>
</section>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Events Area Start ##### -->
<section class="events-area section-padding-100">
    <div class="container">
        <div class="row">
            @foreach($tournaments as $tournament)
            <div class="col-12 col-md-6 col-lg-4">
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
                        
                        <p>You are already registered for this tournament.</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
<!-- ##### Events Area End ##### -->

@endsection