@extends('layout.main.master')

@section('title', 'Report | WIN STREAX')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">Data Report Tournament</h2>
    <a href="/admin/report/download-pdf" class="btn mb-2 btn-primary">Download Report</a>
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
              <th class="text-dark">Poin</th>
              <th class="text-dark">Ranking</th>
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