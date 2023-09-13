@if($marketConcentrations->count())
<!-- ======= Recent Blog Posts Section ======= -->
<section id="recent-blog-posts" class="recent-blog-posts" style="background: #FFFFFF;">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-3">
                <header class="section-header">
                    <p>Market <br />
                        <span style="color:#f67624">Concentration</span>
                    </p>
                </header>
            </div>
            <div class="col-lg-9">
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
        </div>


    </div>
</section>
<!-- End Recent Blog Posts Section -->
@endif