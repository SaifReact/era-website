@extends('layouts.web.ajax')
@if($marketConcentrations->count())
<!-- ======= Recent Blog Posts Section ======= -->
<section id="recent-blog-posts" class="recent-blog-posts" style="background: #FFF;">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <!--<i class="ri-briefcase-line icon"
                   style="color: #2db6fa; background: #dbf3fe; font-size:40px; border-radius:5px; padding:15px;"></i>-->
            <p>Market Concentration Hello</p>
        </header>
        <div class="row">
            @foreach($marketConcentrations as $marketConcentration)
            <div class="col-lg-3">
                <div class="post-boxs">
                    <div class="post-img"><img src="{{ $marketConcentration->image }}" class="img-fluid" alt="">
                    </div>
                    <h3 class="post-title" style="text-align:center;">{{ $marketConcentration->title }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section><!-- End Recent Blog Posts Section -->
@endif