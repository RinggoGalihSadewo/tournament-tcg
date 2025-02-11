@extends('layout.main.master')

@section('title', 'Detail Data Admin | PT Global Talentlytica Indonesia')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">{{ $title }}</h2>
    <a href="{{ url('/data-admin') }}" class="btn mb-2 btn-secondary">Kembali</a>
</div>

<div class="row my-4">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <form action="" method="post" enctype="multipart/form-data" id="form-profile"></form>
                        @csrf
                        <div @if($is_profile) class="text-center" @endif>
                            <img src="{{ asset('assets/img/avatars/' . $data->photos) }}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                            <input type="file" id="file" class="form-control mt-3 w-100 @if(!$is_profile) d-none @endif" name="file">
                            <div class="invalid-feedback file"></div>
                        </div>
                        <div class="ml-3 w-100">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" id="name" class="form-control" value="{{$data->name}}" @if(!$is_profile) disabled @endif>
                                <div class="invalid-feedback name"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control" value="{{$data->email}}" @if(!$is_profile) disabled @endif>
                                <div class="invalid-feedback email"></div>
                            </div>
                            @if($is_profile)
                                <input type="hidden" id="id" class="form-control" value="{{$data->id}}" @if(!$is_profile) disabled @endif>
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" id="password" class="form-control" name="password" value="" placeholder="Password">
                                    <div class="invalid-feedback password"></div>
                                </div>
                                <div class="form-group">
                                    <label for="passwordConfirm">Konfirmasi Password Baru</label>
                                    <input type="password" id="passwordConfirm" class="form-control" name="passwordConfirm" value="" placeholder="Password Baru">
                                    <div class="invalid-feedback passwordConfirm"></div>
                                </div>
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary" id="btnUpdateAdmin">Update</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection