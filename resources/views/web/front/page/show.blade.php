@extends('layouts.web.app_without_contact')
@section('title')
{{ $page->title }}
@endsection
@section('meta')
@parent
<meta name="description" content="{{ $page->meta }}" />
<meta name="keyword" content="{{ $page->meta }}" />
@endsection
@section('css')
@parent
<link href="{{ asset('css/pages.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('web.front.partials.header')

<main id="main">
    @include('web.front.partials.breadcrumb')
    <section class="inner-page">
        <article class="entry entry-single" data-aos="fade-up">
            {!! $page->content !!}
        </article>
    </section>
</main><!-- End #main -->
@endsection