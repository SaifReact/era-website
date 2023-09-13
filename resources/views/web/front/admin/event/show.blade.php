@extends('layouts.web.app')
@section('title')
    {{ $event->title }}
@endsection
@section('meta')
    @parent
    <meta name="description" content="{{ $event->meta }}" />
    <meta name="keyword" content="{{ $event->meta }}" />
@endsection
@section('content')
    @include('web.front.partials.header')

    <main id="main">
        @include('web.front.partials.breadcrumb')

        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12 entries">
                        <article class="entry entry-single">
                            <div class="entry-img">
                                <img src="{{ $event->image }}" alt="" class="img-fluid">
                            </div>
                            <h2 class="entry-title">
                                <a href="{{ route('admin.event-show', ['event' => $event->slug, 'item' => $item]) }}">{{ $event->title }}</a>
                            </h2>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="{{ route('event-list', ['publish_at'=>$event->publish_at, 'item' => $item]) }}"><time datetime="{{ $event->publish_at }}">{{ \Carbon\Carbon::parse($event->publish_at)->format('M d, Y') }}</time></a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                {!! $event->detail !!}
                            </div>

                            <div class="entry-footer">
                                @if($event->meta)
                                    <hr />
                                <i class="bi bi-tags"></i>
                                <span class="tags">{{$event->meta}}</span>
                                @endif
                            </div>

                        </article><!-- End blog entry -->
                    </div><!-- End blog entries list -->
                </div>

            </div>
        </section><!-- End Blog Single Section -->

    </main><!-- End #main -->
@endsection
