@extends('layouts.web.ajax')
@if($banners->count())
<section id="hero">
    <div class="hero-container">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">

            <ol id="hero-carousel-indicators" class="carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">
                @foreach($banners as $key => $banner)
                <div class="carousel-item @if($key===0) active @endif"
                    style="background-image: url({{ $banner->banner_image }})">
                    <div class="carousel-container">
                        <div class="container">
                            <h2
                                class="larger-text animate__animated animate__slower @if(($key%2)==0) animate__fadeInUp @else animate__fadeInDown @endif">
                                {{ $banner->banner_text }}</h2>
                            @if($banner->button_url && $banner->button_text)
                            <a href="@if($banner->button_text) {{ $banner->button_url }} @endif" target="_blank"
                                class="large-text btn-get-started scrollto animate__animated animate__slower @if(($key%2)==0) animate__fadeInDown @else animate__fadeInUp @endif">{{ $banner->button_text }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

        </div>
    </div>
</section><!-- End Hero Section -->
@endif