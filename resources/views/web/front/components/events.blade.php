@extends('layouts.web.ajax')
@if($events->count())
<!-- ======= Recent Blog Posts Section ======= -->
<section id="recent-blog-posts" class="recent-blog-posts text-start" style="background:#F6F9FF; padding-bottom:20px;">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <!--  <i class="ri-file-text-line icon"
                   style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>-->
            <p>News & <span style="color:#F67624">Events</span>
            </p>
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