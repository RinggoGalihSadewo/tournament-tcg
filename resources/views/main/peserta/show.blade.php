@extends('layout.main.master')

@section('title', 'Detail Data Peserta | PT Global Talentlytica Indonesia')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">Detail Data Peserta</h2>
    <a href="{{ url('/data-peserta') }}" class="btn mb-2 btn-secondary">Kembali</a>
</div>

<div class="row my-4">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <img src="{{ asset('assets/img/avatars/' . $data->photos) }}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                    </div>
                    <div class="ml-3 w-100">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" class="form-control" value="{{$data->name}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" value="{{$data->email}}" disabled>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label>Nilai (X,Y,Z,W)</label>
                            </div>
                            <div class="col-12 col-sm-3 mb-3 mb-sm-0">
                                <input type="number" id="x" class="form-control" name="x" value="{{$data->grade->x}}" placeholder="X" min="1" max="33" disabled>
                                <div class="invalid-feedback x"></div>
                            </div>
                            <div class="col-12 col-sm-3 mb-3 mb-sm-0">
                                <input type="number" id="y" class="form-control" name="y" value="{{$data->grade->y}}" placeholder="Y" min="1" max="23" disabled>
                                <div class="invalid-feedback y"></div>
                            </div>
                            <div class="col-12 col-sm-3 mb-3 mb-sm-0">
                                <input type="number" id="z" class="form-control" name="z" value="{{$data->grade->z}}" placeholder="Z" min="1" max="18" disabled>
                                <div class="invalid-feedback z"></div>
                            </div>
                            <div class="col-12 col-sm-3 mb-3 mb-sm-0">
                                <input type="number" id="w" class="form-control" name="w" value="{{$data->grade->w}}" placeholder="W" min="1" max="13" disabled>
                                <div class="invalid-feedback w"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Small table -->
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-body">
          <!-- table -->
          <table class="table table-hover w-100">
            <thead>
              <tr>
                <th class="text-dark">Aspek</th>
                <th class="text-dark text-center">1</th>
                <th class="text-dark text-center">2</th>
                <th class="text-dark text-center">3</th>
                <th class="text-dark text-center">4</th>
                <th class="text-dark text-center">5</th>
              </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td class="text-left">Aspek Intelegensi</td>
                    <td>@if($result_intelegensi >= 0.5 && $result_intelegensi < 3.175 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_intelegensi >= 3.175 && $result_intelegensi < 5.85 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_intelegensi >= 5.85 && $result_intelegensi < 8.525 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_intelegensi >= 8.525 && $result_intelegensi < 11.2 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_intelegensi >= 11.2 && $result_intelegensi <= 13.5 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                </tr>
                <tr class="text-center">
                    <td class="text-left">Aspek Numerical Ability</td>
                    <td>@if($result_numerical_ability >= 0.5 && $result_numerical_ability < 1.625 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_numerical_ability >= 1.625 && $result_numerical_ability < 3.25 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_numerical_ability >= 3.25 && $result_numerical_ability < 4.875 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_numerical_ability >= 4.875 && $result_numerical_ability < 6.5 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                    <td>@if($result_numerical_ability >= 6.5 && $result_numerical_ability <= 7.25 ) <span class="badge badge-lg bg-success bg-ronded text-white"><i class="fe fe-star fe-16"></i></span> @endif</td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div> <!-- simple table -->
</div>

@endsection