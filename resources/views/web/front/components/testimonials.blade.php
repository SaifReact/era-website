@extends('layouts.web.ajax')
<section id="testimonials" class="testimonials text-start">
    <header class="section-header">
        <p>Testimonials</p>
    </header>
    @if($testimonials->count())
    <div class=" testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="200">
        <div class="swiper-wrapper">
            @foreach($testimonials as $testimonial)
            <div class="swiper-slide">
                <div class="testimonial-item">
                    <p style="color:#000">{{ $testimonial->message }}</p>
                    <div class="row">
                        <div class="col-lg-3">
                            <img src="{{ $testimonial->photo }}" class="testimonial-img"
                                alt="{{ $testimonial->client_name }} - {{ $testimonial->person_name }}, {{ $testimonial->designation }}">
                        </div>
                        <div class="col-lg-9">
                            <h3>{{ $testimonial->person_name }}</h3>
                            <span>{{ $testimonial->designation }}</span>
                            <p>{{ $testimonial->client_name }}</p>
                        </div>
                    </div>
                </div>
            </div><!-- End testimonial item -->
            @endforeach
        </div>
        <div class=" swiper-pagination"></div>
    </div>
    @endif
</section>

@section('js')
@parent
<script src="{{ asset('js/testimonials.js') }}" defer></script>
<script src="{{ asset('js/clients.js') }}" defer></script>
@endsection