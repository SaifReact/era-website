@extends('layouts.web.ajax')
@if($managements->count())
<!-- ======= Team Section ======= -->
<section id="team" class="team text-start" style="background: #f6f9ff;">

    <div class="container" data-aos="fade-up">

        <header class="section-header">
            <i class="ri-team-line icon"
                style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>
            <p>Policy Makers</p>
        </header>

        <div class="row gy-4 d-flex justify-content-center">
            @foreach($managements as $management)
            <div class="col-lg-3 col-md-6 d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ $management->url }}">
                    <div class="member">
                        <div class="member-img">
                            <img src="{{ $management->photo }}" class="img-fluid"
                                alt="{{ $management->person_name }}, {{ $management->designation }}">
                        </div>
                        <div class="member-info">
                            <h4>{{ $management->person_name }}</h4>
                            <span>{{ $management->designation }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section><!-- End Team Section -->
@endif