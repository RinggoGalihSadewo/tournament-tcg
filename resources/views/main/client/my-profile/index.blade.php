@extends('layout.client.master')

@section('title', 'Login | WIN STREAX')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<section class="breadcumb-area bg-img bg-overlay" style="background-image: url({{asset('assets/img/client/bg-img/bg-1.jpg')}});">
    <div class="bradcumbContent">
        <p>My Profile</p>
        <h2>Account Information</h2>
    </div>
</section>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Login Area Start ##### -->
<section class="login-area section-padding-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="login-content">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">History Tournament</a>
                    </li>
                  </ul>

                  <!-- Tab content -->
                  <div class="tab-content" id="myTabContent" style="margin-top:20px">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                      <!-- Login Form -->
                      <div class="login-form">
                        <form action="" method="post" id="form_update_my_profile" enctype="multipart/form-data">
                          <input type="hidden" id="id_user" value="{{ $user->id_user }}"/>
                            <div class="d-flex justify-content-center">
                                <div class="form-group">
                                  <img src="{{ asset('assets/img/profile/'. $user->photo) }}" id="preview" alt="Preview" class="img-fluid" style="width: 200px; height: 200px; object-fit: cover; border-radius: 10px;">
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
                                  <input type="text" id="username" class="form-control form-control" name="username" placeholder="Username" required="" autofocus="" value="{{ $user->username }}">
                                  <div class="invalid-feedback text-left username"></div>
                                </div>          
                                <div class="form-group col-6">
                                  <label for="name" class="sr-only">Name</label>
                                  <input type="text" id="name" class="form-control form-control" name="name" placeholder="Full Name" required="" autofocus="" value="{{ $user->name }}">
                                  <div class="invalid-feedback text-left name"></div>
                                </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-6">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" id="email" class="form-control form-control" name="email" placeholder="Email" required="" autofocus="" value="{{ $user->email }}">
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
                              <input type="number" id="phone_number" class="form-control form-control" name="phone_number" placeholder="Phone Number" required="" autofocus="" value="{{ $user->phone_number }}">
                              <div class="invalid-feedback text-left phone_number"></div>
                            </div>
                            <div class="form-group">
                              <label for="address" class="sr-only">Address</label>
                              <textarea class="form-control" id="address" rows="4" placeholder="Address">{{ $user->address }}</textarea>
                              <div class="invalid-feedback text-left address"></div>
                            </div>
                            <button type="submit" class="btn oneMusic-btn btn-2 m-2 mt-30" id="btnUpdateProfile">Update Profile</button>
                        </form>
                    </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tournament</th>
                            <th scope="col">Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($tournaments as $tournament)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $tournament->name_tournament }}</td>
                            <td>{{ \Carbon\Carbon::parse($tournament->date_tournament)->format('F d, Y') }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Login Area End ##### -->

@endsection