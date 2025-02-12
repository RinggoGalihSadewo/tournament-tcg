@extends('layout.main.master')

@section('title', 'Data TCG | Tournament TCG')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">Data TCG</h2>
    <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#modalAdmin" id="btnModalTambahAdmin">Tambah Data</button>
    <!-- Modal -->
    <div class="modal fade" id="modalAdmin" tabindex="-1" role="dialog" aria-labelledby="modalAdminLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAdminLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="form-admin" enctype="multipart/form-data">
                @csrf
                <div class="form-group text-center">
                    <div id="result_photos"></div>
                    <input type="file" id="file" class="form-control mt-3 w-50 mx-auto" name="file">
                    <div class="invalid-feedback file"></div>
                </div>
                <div class="form-group">
                    <div id="userId"></div>
                    <label for="name">Nama TCG</label>
                    <input type="text" id="name" class="form-control" name="name" value="" required="" autofocus="" placeholder="Nama">
                    <div class="invalid-feedback name"></div>
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
<div class="row my-4">
  <!-- Small table -->
  <div class="col-md-12">
    <div class="card shadow">
      <div class="card-body">
        <!-- table -->
        <table class="table table-hover datatables w-100" id="dataTable-1">
          <thead>
            <tr>
              <th class="text-dark">#</th>
              <th class="text-dark">Name</th>
              <th class="text-dark">Logo</th>
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