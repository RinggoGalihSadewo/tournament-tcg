@extends('layout.main.master')

@section('title', 'Detail Data TCG | Tournament TCG')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">{{ $title }}</h2>
    <a href="{{ url('/data-admin') }}" class="btn mb-2 btn-secondary">Back</a>
</div>

<div class="row my-4">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <div>
                    <img src="{{ asset('assets/img/tcg/' . $data->photo_tcg) }}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                </div>
                <div style="margin-top: 10px">
                    <p>Name TCG</p>
                    <P style="margin-top: -10px">{{ $data->name_tcg }}</P>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection