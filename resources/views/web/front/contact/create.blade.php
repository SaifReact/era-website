@extends('layouts.web.app_without_contact')
@section('title')
Contact
@endsection
@section('meta')
@parent
@endsection
@section('content')
@include('web.front.partials.header')

<main id="main">
    @include('web.front.partials.breadcrumb')
    <section class="inner-page">
        <div class="container">
            <article class="entry entry-single" data-aos="fade-up">
                <div id="contact" class="contact">
                    @if($contacts->count())
                    <div class="row mb-4">
                        <div class="col-lg-3">
                            <i class="bi bi-geo-alt"> </i>
                            @if($location)
                            <p style="font-size:14px;"> {{ $location->address }} </p>
                            @endif
                        </div>
                        <div class="col-lg-3">
                            <i class="bi bi-telephone"></i>
                            <p style="font-size:14px;">{{ $companyInfo->phone }}</p>
                        </div>
                        <div class="col-lg-3">
                            <i class="bi bi-envelope"></i>
                            <p style="font-size:14px;">{{ $companyInfo->email }}</p>
                        </div>
                        <div class="col-lg-3">
                            <i class="bi bi-stopwatch"></i>
                            <p style="font-size:14px;">{{ $companyInfo->open_days }}<br>{{ $companyInfo->duration }}
                            </p>

                        </div>
                        @foreach($contacts as $contact)
                        <!-- <div class="col-md-12 col-lg">
                                        <a href="tel:{{ $contact->contact_no }}">
                            <div class="card mb-3 d-flex justify-content-around flex-sm-column py-3">
                                <div class="row g-0">
                                    <div class="col-md-4 d-flex justify-content-center contact-photo px-1">
                                        <img src="@if($contact->photo) {{ $contact->photo }} @else {{ asset('images/front/user-icon.png') }} @endif"
                                            class="bd-placeholder-img img-fluid avatar avatar-sm"
                                            alt="{{ $contact->person_name }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title d-md-flex justify-content-md-center">
                                                {{ $contact->person_name }}</h5>
                                            <p class="card-text d-md-flex justify-content-md-center">
                                                {{ $contact->contact_no }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div> -->
                        @endforeach
                    </div>
                    @endif
                    <div class="row">
                        @if($location)
                        <div class="col-sm-12 col-md-6">
                            <div class="ratio ratio-4x3 border rounded">
                                <iframe
                                    src="https://maps.google.com/maps?q={{ $location->location_name }}&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                    allowfullscreen="true">
                                </iframe>
                            </div>
                        </div>
                        @endif
                        <div class="col-sm-12 col-md-6">
                            <form action="{{ route('contact-store') }}" method="post" class="php-email-form">
                                {{ csrf_field() }}
                                <div class="row gy-4">

                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name"
                                            required>
                                    </div>

                                    <div class="col-md-6 ">
                                        <input type="email" class="form-control" name="email" placeholder="Your Email"
                                            required>
                                    </div>

                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="subject" placeholder="Subject"
                                            required>
                                    </div>

                                    <div class="col-md-12">
                                        <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                            required></textarea>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>

                                        <button type="submit">Send Message</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</main><!-- End #main -->
@endsection