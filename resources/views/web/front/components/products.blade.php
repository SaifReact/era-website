@extends('layouts.web.ajax')
@if($products->count())
<!-- ======= Services Section ======= -->
<section id="services" class="services text-start" style="background:#F6F9FF;">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <span>Our</span> <span style="color:#F67624">Products</sapn>
        </header>
        <div class="row" style="position:relative;">
            <div class="products-slider swiper-container" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    @foreach($products as $product)
                    <div class="swiper-slide">
                        <div data-aos="fade-up" data-aos-delay="200">
                            <div class="service-box product-{{$product->id}}">
                                <h3>{{ $product->product_name }}</h3>
                                <p>{{ $product->summary }}</p>
                                <a href="{{ $product->url }}" class="read-more"><span>View Features</span> <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="swiper-button-next"><i class="bi bi-arrow-right-circle-fill"></i></div>
            <div class="swiper-button-prev"><i class="bi bi-arrow-left-circle-fill"></i></div>
        </div>
    </div>
</section><!-- End Services Section -->
@endif
@section('js')
@parent
<script src="{{ asset('js/products.js') }}" defer></script>
@endsection