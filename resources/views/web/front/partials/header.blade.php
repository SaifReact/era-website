<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
    
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}"
                class="logo d-flex align-items-center @if($companyInfo->tagline) border-end @endif">
                <img src="{{ asset('images/front/ERA-Logo.png') }}" alt="{{ $companyInfo->logo_alt }}">
            </a>
            @if($companyInfo->tagline)<sub
                class="d-none d-md-inline text-era-preferred pb-2 ms-2">{{ $companyInfo->tagline }}</sub>@endif
        </div>


        @include('web.front.partials.menu')
    </div>
</header><!-- End Header -->