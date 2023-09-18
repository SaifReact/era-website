@extends('layouts.web.ajax')
@if($events->count())
<!-- ======= Recent Blog Posts Section ======= -->
<section id="recent-blog-posts" class="recent-blog-posts text-start" style="background:#F6F9FF; padding-bottom:20px;">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <span>News & </span> <span style="color:#F67624">Events</span>
        </header>

        <div class="row">
            @foreach($events as $event)
            <div class="col-lg-4">
                <div class="post-box">
                    <div class="post-img"><img src="{{ $event->thumbnail }}" class="img-fluid"
                            alt="{{ $event->title }}"></div>
                    <span class="post-date">{{ ($event->publish_at) }}</span>
                    <!--<span class="post-date">{{ \Carbon\Carbon::parse($event->publish_at)->format('M d, Y') }}</span>-->
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