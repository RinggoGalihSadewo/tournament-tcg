@extends('layout.client.master')

@section('title', 'Home | WIN STREAX')

@section('content')

<!-- ##### Hero Area Start ##### -->
<section class="hero-area">
  <div class="hero-slides owl-carousel">
      <!-- Single Hero Slide -->
      <div class="single-hero-slide d-flex align-items-center justify-content-center">
          <!-- Slide Img -->
          <div class="slide-img bg-img" style="background-image: url({{asset('assets/img/client/bg-img/bg-1.jpg')}});"></div>
          <!-- Slide Content -->
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="hero-slides-content text-center">
                          <h6 data-animation="fadeInUp" data-delay="100ms">Tournament</h6>
                          <h2 data-animation="fadeInUp" data-delay="300ms">WIN STREAX <span>WIN STREAX</span></h2>
                          <a data-animation="fadeInUp" data-delay="500ms" href="#" class="btn oneMusic-btn mt-50">See All Tournament <i class="fa fa-angle-double-right"></i></a>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Single Hero Slide -->
      <div class="single-hero-slide d-flex align-items-center justify-content-center">
          <!-- Slide Img -->
          <div class="slide-img bg-img" style="background-image: url({{asset('assets/img/client/bg-img/bg-2.jpg')}});"></div>
          <!-- Slide Content -->
          <div class="container">
              <div class="row">
                  <div class="col-12">
                    <div class="hero-slides-content text-center">
                        <h6 data-animation="fadeInUp" data-delay="100ms">Tournament</h6>
                        <h2 data-animation="fadeInUp" data-delay="300ms">WIN STREAX <span>WIN STREAX</span></h2>
                        <a data-animation="fadeInUp" data-delay="500ms" href="#" class="btn oneMusic-btn mt-50">See All Tournament <i class="fa fa-angle-double-right"></i></a>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- ##### Hero Area End ##### -->
@endsection