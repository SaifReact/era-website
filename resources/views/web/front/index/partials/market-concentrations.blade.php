@if($marketConcentrations->count())
<!-- ======= Recent Blog Posts Section ======= -->
<section id="recent-blog-posts" class="recent-blog-posts" style="background: #FFFFFF;">
    <div class="container" data-aos="fade-up">
        <div class="section-content">
            <header class="section-header">
                <span>Market</span> <span style="color:#f67624">Concentration</span>
            </header>
            <div class="section-body">

                @foreach($marketConcentrations as $marketConcentration)
                <div class="post-boxs">
                    <div class="post-img"><img src="{{ $marketConcentration->image }}" class="img-fluid" alt="">
                    </div>
                    <h3 class="post-title" style="text-align:center;">{{ $marketConcentration->title }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- End Recent Blog Posts Section -->
@endif