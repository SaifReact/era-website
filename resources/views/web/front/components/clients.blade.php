@extends('layouts.web.ajax')

@if($clientCategoriesWithClients->count() && $clientsCount)
<section id="clients" class="clients text-start">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <p style="color:#f67624">Clients</p>
        </header>
        <section class="clients-slider">
            <div class="container">
                <div class="row">
                    @foreach($clientCategoriesWithClients as $clientCategory)
                    <!-- @if($clientCategory->ordered_clients_count) -->
                    <!-- <h4 class="section-sub-header mt-4">{{ $clientCategory->category_name }}</h4> -->
                    <!-- <div class="clients-slider swiper-container"> -->
                    <!-- <div class="swiper-wrapper d-flex align-items-center"> -->
                    @if($clientCategory->ordered_clients_count)
                    @foreach($clientCategory->orderedClients as $client)
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="square-holder">
                            @if(!empty($client->url))
                            <a href="{{ $client->url }}" target="_blank"><img src="{{ $client->logo }}"
                                    alt="{{ $client->client_name }}"></a>
                            @else
                            <img src="{{ $client->logo }}" alt="{{ $client->client_name }}">
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </section>
        <!-- </div> -->
        <!-- <div class="swiper-pagination"></div> -->
        <!-- </div> -->
        <!-- @endif -->
        @endforeach
    </div>
</section><!-- End Clients Section -->
@endif
@section('js')
@parent
<script src="{{ asset('js/clients.js') }}" defer></script>
@endsection