@extends('layouts.web.app_front_page')
@section('title')
Welcome!
@endsection
@section('meta')
@parent
<meta name="description" content="ERA-Infotech Limited, Banking Software Solution" />
<meta name="keyword" content="ERA-Infotech Limited, Banking Software Solution" />
@endsection
@section('content')
@include('web.front.partials.header')
@include('web.front.index.partials.banners')

<main id="main">
    @include('web.front.index.partials.resources')
    @include('web.front.index.partials.market-concentrations')
    <!--
        <div id="front-about-us" class="ajax-lazy text-center" data-loader="ajax" data-src="{{ route('front.components.aboutUs') }}">
            @include('web.front.partials.ajax-loader-block')
        </div>
    -->
    <div id="front-products" class="ajax-lazy text-center" data-loader="ajax"
        data-src="{{ route('front.components.products') }}">
        @include('web.front.partials.ajax-loader-block')
    </div>


    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-6">
                <!-- <div id="front-testimonials" class="ajax-lazy text-center" data-loader="ajax"
                    data-src="{{ route('front.components.testimonials') }}">
                    @include('web.front.partials.ajax-loader-block')
                </div> -->
            </div>
            <div class="col-lg-6">
                <div id="front-clients" class="ajax-lazy text-center" data-loader="ajax"
                    data-src="{{ route('front.components.clients') }}">
                    @include('web.front.partials.ajax-loader-block')
                </div>
            </div>
        </div>
    </div>
    <!-- 
        <div id="front-portfolios" class="ajax-lazy text-center" data-loader="ajax"
        data-src="{{ route('front.components.portfolios') }}">
        @include('web.front.partials.ajax-loader-block')
    </div> 
-->


    <div id="front-events" class="ajax-lazy text-center" data-loader="ajax"
        data-src="{{ route('front.components.events') }}">
        @include('web.front.partials.ajax-loader-block')
    </div>
    <!--
        <div id="front-managements" class="ajax-lazy text-center" data-loader="ajax" data-src="{{ route('front.components.managements') }}">
            @include('web.front.partials.ajax-loader-block')
        </div>
    -->
</main><!-- End #main -->
@endsection