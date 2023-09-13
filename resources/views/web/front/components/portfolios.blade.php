@extends('layouts.web.ajax')
@if($portfolios->count())
<!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio text-start">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <p>Check our latest work</p>
        </header>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-12 d-flex justify-content-center">
                <ul id="portfolio-flters">
                    <li data-filter="*" class="filter-active">All</li>
                    @if($portfolioCategories)
                    @foreach($portfolioCategories as $portfolioCategory)
                    <li data-filter=".filter-{{ $portfolioCategory->slug }}">{{ $portfolioCategory->category_name }}
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
            @foreach($portfolios as $portfolio)
            <div class="col-lg-4 col-md-6 portfolio-item filter-{{ $portfolio->portfolio_category->slug }}">
                <div class="portfolio-wrap">
                    <img src="{{ $portfolio->thumbnail }}" class="img-fluid" alt="{{ $portfolio->name }}">
                    <div class="portfolio-info">
                        <h4>{{ $portfolio->name }}</h4>
                        <p>{{ $portfolio->portfolio_category->category_name }}</p>
                        <div class="portfolio-links">
                            <a href="{{ $portfolio->image }}" data-gallery="portfolioGallery" class="portfokio-lightbox"
                                title="{{ $portfolio->name }}"><i class="bi bi-plus"></i></a>
                            {{--<a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>--}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section><!-- End Portfolio Section -->
@endif
@section('js')
@parent
<script src="{{ asset('js/portfolios.js') }}" defer></script>
@endsection