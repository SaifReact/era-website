@if($banners->count())
<section id="hero">
    <div class="hero-container">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
        <!-- <div> -->

            <!-- <ol id="hero-carousel-indicators" class="carousel-indicators"></ol> -->

            <div class="carousel-inner" role="listbox">
                @foreach($banners as $key => $banner)
                <div class="carousel-item @if($key===0) active @endif">
                    <div class="banner-container">
                        <div class="banner-image">
                            <img src="{{ $banner->banner_image }}" alt="{{$banner->button_text}}" >
                        </div>
                            <div class="carousel-caption">
                                <h2
                                    class="medium-text animate__animated animate__slower @if(($key%2)==0) animate__fadeInUp @else animate__fadeInDown @endif">
                                <span class="h-color">{{ $banner->banner_text }}</span><br>{{ $banner->button_text }}</h2>
                            </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section><!-- End Hero Section -->
@endif