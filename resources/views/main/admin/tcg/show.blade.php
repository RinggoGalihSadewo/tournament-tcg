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
                <div class="d-flex align-items-center">
                    <form action="" method="post" enctype="multipart/form-data" id="form-profile"></form>
                        @csrf
                        {{-- <div @if($is_profile) class="text-center" @endif>
                            <img src="{{ asset('assets/img/avatars/' . $data->photos) }}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                            <input type="file" id="file" class="form-control mt-3 w-100 @if(!$is_profile) d-none @endif" name="file">
                            <div class="invalid-feedback file"></div>
                        </div> --}}
                        <div class="ml-3 w-100">
                            <div class="form-group">
                                <label for="name">Name TCG</label>
                                <input type="text" id="name" class="form-control" value="{{$data->name}}" @if(!$is_profile) disabled @endif>
                                <div class="invalid-feedback name"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection