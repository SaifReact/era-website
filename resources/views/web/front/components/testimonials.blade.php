@extends('layouts.web.ajax')
<section id="testimonials" class="testimonials text-start">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-6">
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
            </div>
            <div class="col-lg-6">
                <header class="section-header">
                    <p style="color:#F67624">Clients</p>
                </header>
                <section class="section section-default mt-none mb-none">
                    <div class="container">
                        <h2 class="mb-sm">Our <strong>Partners</strong></h2>
                        <strong>
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt=""
                                            src="https://www.pmits.co.uk/portals/0/images/partners/solar-communications-200.png" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt=""
                                            src="https://www.pmits.co.uk/portals/0/images/partners/cbf-200.png" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt=""
                                            src="https://www.pmits.co.uk/portals/0/images/partners/gxs-200.png" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt=""
                                            src="https://www.pmits.co.uk/portals/0/images/partners/jpr-200.png" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt=""
                                            src="https://www.pmits.co.uk/portals/0/images/partners/talk-internet-200.png" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt="" src="https://www.pmits.co.uk/Portals/0/img/opera3_logo.png" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt="" src="https://www.pmits.co.uk/Portals/0/pegasus-logo.png" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="square-holder">
                                        <img alt="" src="https://www.pmits.co.uk/Portals/0/sage business partner.jpg" />
                                    </div>
                                </div>
                            </div>
                        </strong>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@section('js')
@parent
<script src="{{ asset('js/testimonials.js') }}" defer></script>
<script src="{{ asset('js/clients.js') }}" defer></script>
@endsection