@extends('layout.main.master')

@section('title', 'Report | WIN STREAX')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">Data Report Tournament</h2>
    <div class="row">
      <div class="col-7">
        <select class="form-control" id="tournament" name="tournament" placeholder="Tournament" style="width: 100%" value="{{ $tournaments[0]->id_tournament }}">
          @foreach($tournaments as $key => $tournament)
          <option value="{{$tournament->id_tournament}}">{{ $tournament->name_tournament }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-5">
        <a id="downloadBtn" href="/admin/report/download-pdf/{{$tournaments[0]->id_tournament}}" class="btn mb-2 btn-primary w-100">Download</a>
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