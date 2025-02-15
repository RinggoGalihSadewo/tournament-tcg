@extends('layout.main.master')

@section('title', $title . ' | Tournament TCG')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">{{ $title }}</h2>
    <div>
        <a href="{{ url('/admin/tournament') }}" class="btn mb-2 btn-secondary mr-1">Back</a>
        <button type="button" class="btn mb-2 btn-primary" id="btnTambahTournament">Save</button>
    </div>
</div>

<div class="row my-4">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('tournament.store') }}" method="POST" id="form_tournament" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="name_tournament">Name Tournament</label>
                            <input type="text" id="name_tournament" class="form-control" name="name_tournament" required autofocus>
                            <div class="invalid-feedback text-left name_tournament"></div>
                        </div>          
                        <div class="form-group col-6">
                            <label for="date_tournament">Date Tournament</label>
                            <div class="input-group">
                                <input type="text" class="form-control drgpicker" id="date_tournament" name="date_tournament" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                                </div>
                            </div>
                            <div class="invalid-feedback text-left date_tournament"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description_tournament">Description Tournament</label>
                        <textarea class="form-control" id="description_tournament" name="description_tournament" rows="4"></textarea>
                        <div class="invalid-feedback text-left description_tournament"></div>
                    </div>
                    <div class="form-group">
                        <img src="{{ asset('assets/img/avatars/default.png') }}" id="preview" alt="Preview" 
                             class="img-fluid d-none" style="max-width: 200px; border: 0.1px solid rgb(118, 118, 118); border-radius: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="photo_tournament">Photo Tournament</label>
                        <input type="file" id="file" class="form-control" style="width: 30%" name="file">
                        <div class="invalid-feedback file"></div>
                    </div>
                    <div class="form-group">
                        <p class="mb-2"><strong>Status Tournament</strong></p>
                        <div class="d-flex" style="gap: 12px">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value="active" checked>
                                <label class="custom-control-label" for="customRadio1">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" value="inactive">
                                <label class="custom-control-label" for="customRadio2">In Active</label>
                            </div>
                            
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
