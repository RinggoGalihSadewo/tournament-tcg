@extends('layout.client.master')

@section('title', 'Deck Log | WIN STREAX')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<section class="breadcumb-area bg-img bg-overlay" style="background-image: url({{asset('assets/img/client/bg-img/bg-1.jpg')}});">
    <div class="bradcumbContent">
        <p>See Deck Log</p>
        <h2>Deck Log</h2>
    </div>
</section>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Events Area Start ##### -->
<section class="events-area section-padding-100">
    <div class="container">
        <div class="row">
            @foreach($tcgs as $tcg)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="single-event-area mb-30">
                    <div class="event-thumbnail">
                        <img src="{{ asset('assets/img/deckLog/' . (count($tcg->decklog) > 0 && $tcg->decklog[0]->photo ? $tcg->decklog[0]->photo : 'no-image.jpg')) }}" alt="Preview" class="preview" data-index="{{ $loop->index }}" style="width: 100%; height: 200px; object-fit: cover">
                    </div>
                    <div class="event-text">
                        <h4>{{ $tcg->name_tcg }}</h4>                        
                    </div>
                </div>
                <form action="/deck-log" method="post" id="form_deck_log_{{ $loop->index }}" enctype="multipart/form-data">
                    @csrf  <!-- Include CSRF token if you're using Laravel -->
                    <div class="form-row">
                        <div class="form-group mb-3 col-12">
                            <input type="file" class="form-control file-input" name="file" data-index="{{ $loop->index }}">
                        </div>
                        <!-- Input hidden untuk id_tcg -->
                        <input type="hidden" name="id_tcg" value="{{ $tcg->id_tcg }}">
                    </div>
                </form>
                @if (count($tcg->decklog) > 0)
                <button type="submit" class="btn oneMusic-btn btn-2 m-2 w-100" onclick="hapusDeckLog({{$tcg->decklog[0]->id_tcg}})">Delete</button>
                @endif
            </div>
        @endforeach
        
        
        </div>

    </div>
</section>
<!-- ##### Events Area End ##### -->

@endsection