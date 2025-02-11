@extends('layout.auth.master')

@section('title', 'Login | PT Global Talentlytica Indonesia')

@section('content')

<div class="wrapper vh-100">
    <div class="row align-items-center h-100">
      <form action="" method="post" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
        @csrf
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/') }}">
          <img src="{{ asset('assets/img/logo.png') }}" alt="" width="180px">
        </a>
        <div class="form-group">
          <label for="email" class="sr-only">Email</label>
          <input type="email" id="email" class="form-control form-control" name="email" placeholder="Email" required="" autofocus="" value="admin@gmail.com">
          <div class="invalid-feedback text-left email"></div>
        </div>
        <div class="form-group">
          <label for="password" class="sr-only">Password</label>
          <input type="password" id="password" class="form-control form-control" name="password" placeholder="Password" required="" value="12345678">
          <div class="invalid-feedback text-left password"></div>
        </div>
        <button class="btn btn-primary btn-block" type="submit" id="btnLogin">Login</button>
        <p class="mt-5 mb-3 text-muted">© Ringgo Galih Sadewo</p>
      </form>
    </div>
</div>

@endsection