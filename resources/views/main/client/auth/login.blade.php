@extends('layout.client.master')

@section('title', 'Login | WIN STREAX')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<section class="breadcumb-area bg-img bg-overlay" style="background-image: url({{asset('assets/img/client/bg-img/bg-1.jpg')}});">
    <div class="bradcumbContent">
        <p>See what’s new</p>
        <h2>Login</h2>
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
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" id="email" class="form-control form-control" name="email" placeholder="Email" required="" autofocus="">
                                <div class="invalid-feedback text-left email"></div>
                              </div>
                              <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" id="password" class="form-control form-control" name="password" placeholder="Password" required="">
                                <div class="invalid-feedback text-left password"></div>
                              </div>
                            <button type="submit" class="btn oneMusic-btn mt-30" id="btnLogin">Login</button>
                        </form>
                    </div>
                    <div class="mt-3">
                        <p>Don't have an account? <a href="/registration">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Login Area End ##### -->

@endsection