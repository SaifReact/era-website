@extends('layouts.web.ajax')

@if($clientCategoriesWithClients->count() && $clientsCount)
<section id="clients" class="clients text-start">
    <div class="container" data-aos="fade-up">
        @foreach($clientCategoriesWithClients as $clientCategory)
        @if($clientCategory->ordered_clients_count)
        <h4 class="section-sub-header mt-4">{{ $clientCategory->category_name }}</h4>
        <div class="clients-slider swiper-container">
            <div class="swiper-wrapper d-flex align-items-center">
                @foreach($clientCategory->orderedClients as $client)
                <div class="swiper-slide pe-2 img-fluid d-flex justify-content-center">
                    @if(!empty($client->url))
                    <a href="{{ $client->url }}" target="_blank"><img src="{{ $client->logo }}"
                            alt="{{ $client->client_name }}"></a>
                    @else
                    <img src="{{ $client->logo }}" alt="{{ $client->client_name }}">
                    @endif
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        @endif
        @endforeach
    </div>
</section><!-- End Clients Section -->
@endif
@section('js')
@parent
<script src="{{ asset('js/clients.js') }}" defer></script>
@endsection