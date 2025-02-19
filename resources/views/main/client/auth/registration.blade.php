@extends('layout.client.master')

@section('title', 'Login | WIN STREAX')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<section class="breadcumb-area bg-img bg-overlay" style="background-image: url({{asset('assets/img/client/bg-img/bg-1.jpg')}});">
    <div class="bradcumbContent">
        <p>New Account</p>
        <h2>Registration</h2>
    </div>
</section>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Login Area Start ##### -->
<section class="login-area section-padding-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="login-content">
                    <!-- Login Form -->
                    <div class="login-form">
                        <form action="" method="post" id="form_registration" enctype="multipart/form-data">
                            <div class="d-flex justify-content-center">
                                <div class="form-group">
                                  <img src="{{ asset('assets/img/avatars/default.png') }}" id="preview" alt="Preview" class="img-fluid d-none" style="width: 200px; height: 200px; object-fit: cover; border-radius: 10px;">
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group mb-3 col-12">
                                    <input type="file" class="form-control form-control" id="file" name="file">
                                </div>
                              </div>
                            <div class="form-row">
                                <div class="form-group col-6">
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
                            <button type="submit" class="btn oneMusic-btn mt-30" id="btnRegistration">Registration</button>
                        </form>
                    </div>
                    <div class="mt-3">
                        <p>Already have an account? <a href="/login">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Login Area End ##### -->

@endsection