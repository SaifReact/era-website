@extends('layouts.web.app')
@section('title')
News & Events
@endsection
@section('meta')
@parent
@endsection
@section('content')
@include('web.front.partials.header')
<main id="main">
    @include('web.front.partials.breadcrumb')
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                @if(count($events))
                <div class="col-lg-12 entries">
                    <div class="row g-0 d-flex justify-content-evenly">
                        @foreach($events as $event)
                        <article class="entry col-lg-5">
                            <div class="entry-img">
                                <img src="{{ $event->thumbnail }}" alt="{{ $event->thumbnail }}" class="img-fluid">
                            </div>
                            <h2 class="entry-title">
                                <a href="{{ route('event-show', ['event' => $event->slug, 'item' => $item]) }}">{{ $event->title }}
                                    <span>Hello</span>
                                </a>
                            </h2>
                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i>
                                        <a
                                            href="{{ route('event-list', ['publish_at'=>$event->publish_at, 'item' => $item]) }}"><time
                                                datetime="{{ $event->publish_at }}">{{ \Carbon\Carbon::parse($event->publish_at)->format('M d, Y') }}</time></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="entry-content">
                                <p>
                                    {!! $event->teaser !!}
                                </p>
                                <div class="read-more">
                                    <a href="{{ route('event-show', ['event' => $event->slug, 'item' => $item]) }}">Read
                                        More</a>
                                </div>
                            </div>
                        </article><!-- End blog entry -->
                        @endforeach
                    </div>
                </div><!-- End blog entries list -->

                <div class="col-lg-12 entries">
                    <div class="row g-0">
                        <div class="col d-flex justify-content-center">
                            {!! $events->links() !!}
                        </div>
                    </div>
                </div>
                @else
                <div class="col-lg-12">
                    No events available!
                </div>
                @endif

            </div>
        </div>
    </section><!-- End Blog Section -->
</main><!-- End #main -->
@endsection