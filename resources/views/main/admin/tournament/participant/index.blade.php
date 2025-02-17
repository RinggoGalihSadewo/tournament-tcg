@extends('layout.main.master')

@section('title', 'Data Tournament Participants | WIN STREAX')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">Data Tournament Participants</h2>
    <!-- Modal -->
    <div class="modal fade" id="modalTournamentParticipant" tabindex="-1" role="dialog" aria-labelledby="modalTournamentParticipantLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTournamentParticipantLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="form-admin" enctype="multipart/form-data">
                @csrf
                <div class="form-group text-center">
                  <img src="{{ asset('assets/img/avatars/default.png') }}" id="preview" alt="Preview" class="img-fluid d-none" style="max-width: 200px; border: 0.1px solid rgb(118, 118, 118); border-radius: 10px;">
                </div>
                <div class="form-group mb-3">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" name="file">
                    <label class="custom-file-label" for="file" accept="image/*">Photo Profile</label>
                  </div>
                </div>
                {{-- <div class="form-group flex-fill text-center mx-auto">
                  <input type="file" class="form-control-file" id="file" name="file" accept="image/*">
                </div> --}}
                <div class="form-row">
                    <div class="form-group col-6">
                      <div id="userId"></div>
                      <label for="username" class="sr-only">Username</label>
                      <input type="text" id="username" class="form-control form-control" name="username" placeholder="Username" required="" autofocus="">
                      <div class="invalid-feedback text-left username"></div>
                    </div>          
                    <div class="form-group col-6">
                      <label for="name" class="sr-only">Name</label>
                      <input type="text" id="name" class="form-control form-control" name="name" placeholder="Full Name" required="" autofocus="">
                      <div class="invalid-feedback text-left name"></div>
                    </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" id="email" class="form-control form-control" name="email" placeholder="Email" required="" autofocus="">
                    <div class="invalid-feedback text-left email"></div>
                  </div>    
                  <div class="form-group col-6">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" class="form-control form-control" name="password" placeholder="Password" required="" >
                    <div class="invalid-feedback text-left password"></div>
                  </div>
              </div>
              <div class="form-group mb-3">
                <label for="tournament">Tournament</label>
                <select class="form-control" id="tournament" name="tournament" placeholder="Tournament" >
                  <option disabled>--Choose Tournament--</option>
                  @foreach($tournaments as $key => $tournament)
                  <option value="{{$tournament->id_tournament}}">{{ $tournament->name_tournament }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback text-left tournament"></div>
              </div>
                <div class="form-group">
                  <label for="phone_number" class="sr-only">Phone Number</label>
                  <input type="number" id="phone_number" class="form-control form-control" name="phone_number" placeholder="Phone Number" required="" autofocus="">
                  <div class="invalid-feedback text-left phone_number"></div>
                </div>
                <div class="form-group">
                  <label for="address" class="sr-only">Address</label>
                  <textarea class="form-control" id="address" rows="4" placeholder="Address"></textarea>
                  <div class="invalid-feedback text-left address"></div>
                </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
            <div class="modal-button mt-2"></div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-end" style="gap: 5px;">
      <a href="/admin/tournament-participants/pairing" class="btn mb-2 btn-primary">Start Pairing</a>
      <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#modalTournamentParticipant" id="btnModalTambahTournamentParticipant">Tambah Data</button>
    </div>
  </div>
</div>

<div class="row mb-4">
  <!-- Small table -->
  <div class="col-md-12">
    <div class="card shadow">
      <div class="card-body">
        <!-- table -->
        <table class="table table-hover datatables w-100" id="dataTable-1">
          <thead>
            <tr>
              <th class="text-dark">#</th>
              <th class="text-dark">Username</th>
              <th class="text-dark">Date Registration</th>
              <th class="text-dark">Tournament</th>
              <th class="text-dark">Action</th>
            </tr>
          </thead>
          <tbody>
    
          </tbody>
        </table>
      </div>
    </div>
  </div> <!-- simple table -->
</div>

@endsection