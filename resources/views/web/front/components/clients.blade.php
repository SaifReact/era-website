@extends('layouts.web.ajax')

@if($clientCategoriesWithClients->count() && $clientsCount)
<section id="clients" class="clients text-start">
    <header class="section-header">
        <p style="color:#f67624">Clients</p>
    </header>

    <div class="row">
        <!-- @foreach($clientCategoriesWithClients as $clientCategory) -->
        <!-- @if($clientCategory->ordered_clients_count) -->
        <!-- <h4 class="section-sub-header mt-4">{{ $clientCategory->category_name }}</h4> -->
        <!-- <div class="clients-slider swiper-container"> -->
        <!-- <div class="swiper-wrapper d-flex align-items-center"> -->
        <div class="clints-wrapper">
            @if($clientCategory->ordered_clients_count)

            @foreach($clientCategory->orderedClients as $client)
            <div class="square-holder">
                @if(!empty($client->url))
                <a href="{{ $client->url }}" target="_blank"><img src="{{ $client->logo }}"
                        alt="{{ $client->client_name }}" data-toggle="tooltip" title="{{ $client->client_name }}" /></a>
                @else
                <img src="{{ $client->logo }}" alt="{{ $client->client_name }}" data-toggle="tooltip"
                    title="{{ $client->client_name }}" />
                @endif
            </div>
            @endforeach


            @endif
        </div>
    </div>
    <!-- </div> -->
    <!-- <div class="swiper-pagination"></div> -->
    <!-- </div> -->
    <!-- @endif -->
    <!-- @endforeach -->
</section><!-- End Clients Section -->
@endif
@section('js')
@parent
<script src="{{ asset('js/clients.js') }}" defer></script>
@endsection