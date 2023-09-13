@extends('layouts.web.app_front_page')
@section('title')
Welcome!
@endsection
@section('meta')
@parent
@endsection
@section('content')
@include('web.front.partials.header')

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
                            {{--<p class="animate__animated animate__fadeInUp">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>--}}
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

<main id="main">

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-emoji-smile"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $resourceInfo->commencement }}"
                                data-purecounter-duration="1"
                                class="purecounter"></span>@if($resourceInfo->commencement)<span>+</span>@endif
                            <p>Commencement</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
                        <div>
                            <span data-purecounter-start="0"
                                data-purecounter-end="{{ $resourceInfo->number_of_installation }}"
                                data-purecounter-duration="1"
                                class="purecounter"></span>@if($resourceInfo->number_of_installation)<span>+</span>@endif
                            <p>No of Installation</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-headset" style="color: #15be56;"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $resourceInfo->customers }}"
                                data-purecounter-duration="1"
                                class="purecounter"></span>@if($resourceInfo->customers)<span>+</span>@endif
                            <p>Customers</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-people" style="color: #bb0852;"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $resourceInfo->team_members }}"
                                data-purecounter-duration="1"
                                class="purecounter"></span>@if($resourceInfo->team_members)<span>+</span>@endif
                            <p>Team Members</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Counts Section -->

    @if($marketConcentrations->count())
    <!-- ======= Recent Blog Posts Section ======= -->
    <section id="recent-blog-posts" class="recent-blog-posts" style="background: #f6f9ff;">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <i class="ri-briefcase-line icon"
                    style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
                <p>Market Concentration</p>
            </header>
            <div class="row">
                @foreach($marketConcentrations as $marketConcentration)
                <div class="col-lg-3">
                    <div class="post-boxs">
                        <div class="post-img"><img src="{{ $marketConcentration->image }}" class="img-fluid" alt="">
                        </div>
                        <h3 class="post-title" style="text-align:center;">{{ $marketConcentration->title }}</h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section><!-- End Recent Blog Posts Section -->
    @endif

    @if($aboutUs)
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
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


    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients" style="background: #f6f9ff;">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <i class="ri-group-line icon"
                    style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
                <p>Our Clients 1st version</p>
            </header>
            {{--<div class="clients-slider swiper-container">
                        <div class="swiper-wrapper align-items-center">
                            @foreach($clients as $client)
                                <div class="swiper-slide">
                                    @if(!empty($client->url))
                                        <a href="{{ $client->url }}"><img src="{{ $client->logo }}" class="img-fluid"
                alt="{{ $client->client_name }}"></a>
            @else
            <img src="{{ $client->logo }}" class="img-fluid" alt="{{ $client->client_name }}">
            @endif
        </div>
        @endforeach
        </div>
        <div class="swiper-pagination"></div>
        </div>--}}
        <h4 class="section-header ms-4">Banks</h4>
        <div class="clients-slider swiper-container">
            <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-1.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-2.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-3.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-4.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-5.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-6.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-7.jpg') }}" class="img-fluid"
                        alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <h4 class="section-header ms-4">NBFI</h4>
        <div class="clients-slider swiper-container">
            <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-8.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-1.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-2.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-3.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-4.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-5.png') }}" class="img-fluid"
                        alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <h4 class="section-header ms-4">GOVT</h4>
        <div class="clients-slider swiper-container">
            <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-6.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-7.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-8.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-9.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-10.jpg') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-11.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-12.png') }}" class="img-fluid"
                        alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <h4 class="section-header ms-4">Enterprise</h4>
        <div class="clients-slider swiper-container">
            <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-13.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-14.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-15.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-16.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-17.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-18.png') }}" class="img-fluid"
                        alt=""></div>
                <div class="swiper-slide"><img src="{{ url('images/front/clients/client-9-19.png') }}" class="img-fluid"
                        alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        </div>
    </section><!-- End Clients Section -->

    @if($products->count())
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <i class="ri-discuss-line icon"
                    style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
                <p>Our Valuable Products</p>
            </header>
            <div class="row gy-4">
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-box product-{{$product->id}}">
                        @if($product->logo)
                        <img src="{{ $product->logo }}" class="img-fluid" />
                        @else
                        <i class="ri-discuss-line icon"></i>
                        @endif
                        <h3>{{ $product->product_name }}</h3>
                        <p>{{ $product->summary }}</p>
                        <a href="{{ $product->url }}" class="read-more"><span>Read More</span> <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <style>
                .product- {
                        {
                        $product->id
                    }
                }

                    {
                    border-bottom: 3px solid {
                            {
                            $product->box_color
                        }
                    }

                    ;
                }

                .product- {
                        {
                        $product->id
                    }
                }

                :hover {
                    background: {
                            {
                            $product->box_color
                        }
                    }

                    ;
                }

                .product- {
                        {
                        $product->id
                    }
                }

                .icon {
                    color: {
                            {
                            $product->box_color
                        }
                    }

                    ;
                }
                </style>
                @endforeach
            </div>
        </div>
    </section><!-- End Services Section -->
    @endif

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <p>Our Clients 2nd version</p>
            </header>

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-banks">Banks</li>
                        <li data-filter=".filter-nbfi">NBFI</li>
                        <li data-filter=".filter-govt">Govt</li>
                        <li data-filter=".filter-enterprise">Enterprise</li>
                    </ul>
                </div>
            </div>

            <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-1.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Banks</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-1.jpg') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-nbfi">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-2.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>NBFI</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-2.jpg') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-govt">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-3.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-3.jpg') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-enterprise">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-4.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-4.png') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-5.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Banks</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-5.png') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-nbfi">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-6.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>NBFI</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-6.png') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-govt">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-7.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-7.jpg') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-enterprise">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-8.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-8.png') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Banks</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9.jpg') }}" data-gallery="portfolioGallery"
                                    class="portfokio-lightbox" title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-nbfi">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-1.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>NBFI</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-1.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-govt">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-2.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-2.jpg') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-enterprise">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-3.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-3.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-4.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Banks</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-4.jpg') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-nbfi">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-5.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>NBFI</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-5.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-govt">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-6.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-6.jpg') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-enterprise">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-7.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-7.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-8.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Banks</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-8.jpg') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-nbfi">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-9.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>NBFI</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-9.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-govt">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-10.jpg') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-10.jpg') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-enterprise">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-11.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-11.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-12.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Banks</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-12.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-govt">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-13.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-13.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-enterprise">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-14.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-14.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-15.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Banks</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-15.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-nbfi">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-16.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>NBFI</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-16.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-govt">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-17.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-17.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-enterprise">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-18.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-18.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 portfolio-item filter-banks">
                    <div class="portfolio-wrap">
                        <img src="{{ url('images/front/clients/client-9-19.png') }}" class="img-fluid"
                            alt="Name / Title here">
                        <div class="portfolio-info">
                            <h4>Name / Title here</h4>
                            <p>Enterprise</p>
                            <div class="portfolio-links">
                                <a href="{{ url('images/front/clients/client-9-19.png') }}"
                                    data-gallery="portfolioGallery" class="portfokio-lightbox"
                                    title="Name / Title here"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Portfolio Section -->

    @if($testimonials->count())
    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials" style="background: #f6f9ff;">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <i class="ri-chat-quote-line icon"
                    style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
                <p>Testimonials</p>
            </header>
            <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            {{--<div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>--}}
                            <p>{{ $testimonial->message }}</p>
                            <div class="profile mt-auto">
                                <img src="{{ $testimonial->photo }}" class="testimonial-img"
                                    alt="{{ $testimonial->client_name }} - {{ $testimonial->person_name }}, {{ $testimonial->designation }}">
                                <h3>{{ $testimonial->client_name }}</h3>
                                <h3>{{ $testimonial->person_name }}</h3>
                                <h4>{{ $testimonial->designation }}</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section><!-- End Testimonials Section -->
    @endif

    @if($events->count())
    <!-- ======= Recent Blog Posts Section ======= -->
    <section id="recent-blog-posts" class="recent-blog-posts">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <i class="ri-file-text-line icon"
                    style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
                <p>Events</p>
            </header>

            <div class="row">
                @foreach($events as $event)
                <div class="col-lg-4">
                    <div class="post-box">
                        <div class="post-img"><img src="{{ $event->thumbnail }}" class="img-fluid"
                                alt="{{ $event->title }}"></div>
                        <span class="post-date">{{ \Carbon\Carbon::parse($event->event_at)->format('M d, Y') }}</span>
                        <h3 class="post-title">{{ $event->title }}</h3>
                        <a href="{{ route('event-show', ['event' => $event->slug]) }}"
                            class="readmore stretched-link mt-auto"><span>Read More</span><i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section><!-- End Recent Blog Posts Section -->
    @endif

    @if($managements->count())
    <!-- ======= Team Section ======= -->
    <section id="team" class="team" style="background: #f6f9ff;">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <i class="ri-team-line icon"
                    style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
                <p>Our Top Management</p>
            </header>

            <div class="row gy-4 d-flex justify-content-center">
                @foreach($managements as $management)
                <div class="col-lg-3 col-md-6 d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ $management->url }}">
                        <div class="member">
                            <div class="member-img">
                                <img src="{{ $management->photo }}" class="img-fluid"
                                    alt="{{ $management->person_name }}, {{ $management->designation }}">
                                {{--<div class="social">
                                        <a href=""><i class="bi bi-twitter"></i></a>
                                        <a href=""><i class="bi bi-facebook"></i></a>
                                        <a href=""><i class="bi bi-instagram"></i></a>
                                        <a href=""><i class="bi bi-linkedin"></i></a>
                                    </div>--}}
                            </div>
                            <div class="member-info">
                                <h4>{{ $management->person_name }}</h4>
                                <span>{{ $management->designation }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section><!-- End Team Section -->
    @endif

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact"> {{--FIXME: Hardcoded ID!--}}

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <i class="ri-contacts-line icon"
                    style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
                <p>Free Consultation</p>
                <h4 style="margin-top:15px;">From banking to NBFI’s, large corporates to government institutes
                    we are there to serve you with your software needs</h4>
            </header>

            <div class="row gy-4">

                <div class="col-lg-6">
                    @if($location)
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Address</h3>
                                <p><a href="{{ $location->map_location }}" target="_blank">
                                        {{ $location->address }}</a>
                                </p>
                            </div>
                        </div>
                        @endif
                        @if($contact)
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Call Us</h3>
                                @if($companyInfo->phone)<p>{{ $companyInfo->phone }}</p>@endif
                                <p><a href="tel:{{ $contact->contact_no }}">{{ $contact->contact_no }}</a></p>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-envelope"></i>
                                <h3>Email Us</h3>
                                <p><a href="mailto:{{ $companyInfo->email }}">{{ $companyInfo->email }}</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-clock"></i>
                                <h3>Open Hours</h3>
                                <p>{{ $companyInfo->open_days }}<br>{{ $companyInfo->duration }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <form action="{{ route('contact-store') }}" method="post" class="php-email-form">
                        {{ csrf_field() }}
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                    required></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>

                                <button type="submit">Send Message</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>

        </div>

    </section><!-- End Contact Section -->

</main><!-- End #main -->
@endsection