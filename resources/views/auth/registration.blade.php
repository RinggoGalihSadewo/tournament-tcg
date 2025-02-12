@extends('layout.auth.master')

@section('title', 'Login | Tournament TCG')

@section('content')

<div class="wrapper vh-100">
    <div class="row align-items-center h-100">
      <form action="" method="post" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
        @csrf
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/') }}">
          <img src="{{ asset('assets/img/logo.png') }}" alt="" width="180px">
        </a>
        <div class="mb-4">
          <h2>Registration Account</h2>
        </div>
        <div class="form-group">
          <label for="username" class="sr-only">Username</label>
          <input type="text" id="username" class="form-control form-control" name="username" placeholder="Username" required="" autofocus="">
          <div class="invalid-feedback text-left username"></div>
        </div>
        <div class="form-group">
          <label for="name" class="sr-only">Name</label>
          <input type="text" id="name" class="form-control form-control" name="name" placeholder="Full Name" required="" autofocus="">
          <div class="invalid-feedback text-left name"></div>
        </div>
        <div class="form-group">
          <label for="email" class="sr-only">Email</label>
          <input type="email" id="email" class="form-control form-control" name="email" placeholder="Email" required="" autofocus="">
          <div class="invalid-feedback text-left email"></div>
        </div>
        <div class="form-group">
          <label for="password" class="sr-only">Password</label>
          <input type="password" id="password" class="form-control form-control" name="password" placeholder="Password" required="" >
          <div class="invalid-feedback text-left password"></div>
        </div>
        <div class="form-group">
          <label for="phone_number" class="sr-only">Phone Number</label>
          <input type="number" id="phone_number" class="form-control form-control" name="phone_number" placeholder="Phone Number" required="" autofocus="">
          <div class="invalid-feedback text-left phone_number"></div>
        </div>
        <div class="form-group">
          <label for="address" class="sr-only">Address</label>
          <input type="text" id="address" class="form-control form-control" name="address" placeholder="Address" required="" autofocus="">
          <div class="invalid-feedback text-left address"></div>
        </div>
        <button class="btn btn-primary btn-block" type="submit" id="btnRegistration">REGISTRATION</button>
        <div class="mt-4">
          <a href="/login"><b>LOGIN</b></a>
        </div>
        <p class="mt-3 mb-3 text-muted">{{ config('app.name') }} © {{ date('Y') }}</p>
      </form>
    </div>
</div>

@endsection