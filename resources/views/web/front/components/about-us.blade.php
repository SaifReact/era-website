@extends('layouts.web.ajax')
@if($aboutUs)
<!-- ======= About Section ======= -->
<section id="about" class="about text-start">
    <div class="container" data-aos="fade-up">
        <div class="row gx-0">
            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="content">
                    <h2>{{ $aboutUs->title }}</h2>
                    <p style="text-align:justify; line-height:25px;">
                        {{ $aboutUs->summary }}
                    </p>
                    <div class="text-center text-lg-start">
                        <a href="{{ $aboutUs->url }}"
                            class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                            <span>Read More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ $aboutUs->image }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section><!-- End About Section -->
@endif