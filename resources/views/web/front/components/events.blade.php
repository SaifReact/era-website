@extends('layouts.web.ajax')
@if($events->count())
<!-- ======= Recent Blog Posts Section ======= -->
<section id="recent-blog-posts" class="recent-blog-posts text-start" style="background:#F6F9FF; padding-bottom:20px;">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <span>News & </span> <span style="color:#F67624">Events</span>
        </header>

        <div class="row" style="position:relative;">
            <div class="events-slider swiper-container" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    @foreach($events as $event)
                    <div class="swiper-slide">
                        <a href="{{ route('event-show', ['event' => $event->slug]) }}">
                            <div class="post-box">
                                <div class="post-img"><img src="{{ $event->thumbnail }}" class="img-fluid"
                                        alt="{{ $event->title }}"></div>
                                <span class="post-date">{{ ($event->publish_at) }}</span>
                                <h3 class="post-title">{{ $event->title }}</h3>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="swiper-button-next"><i class="bi bi-arrow-right-circle-fill"></i></div>
            <div class="swiper-button-prev"><i class="bi bi-arrow-left-circle-fill"></i></div>
        </div>

        <!-- <div class="row">
            @foreach($events as $event)
            <div class="col-lg-4">
                <a href="{{ route('event-show', ['event' => $event->slug]) }}">
                    <div class="post-box">
                        <div class="post-img"><img src="{{ $event->thumbnail }}" class="img-fluid"
                                alt="{{ $event->title }}"></div>
                        <span class="post-date">{{ ($event->publish_at) }}</span>
                        <h3 class="post-title">{{ $event->title }}</h3>
                    </div>
                </a>
            </div>
            @endforeach
        </div> -->
    </div>
</section><!-- End Recent Blog Posts Section -->
@endif
@section('js')
@parent
<script src="{{ asset('js/events.js') }}" defer></script>
@endsection