@extends('layout.main.master')

@section('title', 'Data Tournament | Tournament TCG')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">Data Tournament</h2>
    <a href="/admin/tournament/add">    <button type="button" class="btn mb-2 btn-primary">Tambah Data</button>
    </a>
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
              <th class="text-dark">Name Tournament</th>
              <th class="text-dark">Date Tournament</th>
              <th class="text-dark">Description</th>
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