<!-- ======= Header ======= -->
<header id="header" class="header fixed-top" style="padding-top:15px;">
    <!--<div id="topbar" class="d-none d-md-flex align-items-center" style="background-color:#FFF;">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:{{ $companyInfo->email }}">{{ $companyInfo->email }}</a></i>
                @if($contact)<a href="tel:{{ $contact->contact_no }}"><i class="bi bi-phone d-flex align-items-center ms-4"><span>{{ $contact->contact_no }}</span></i></a>@endif
                @if($location)
                <a href="{{ $location->map_location }}" target="_blank">
                    <i class="bi bi-geo-alt d-flex align-items-center ms-4"><span>{{ $location->address }}</span></i>
                </a>
                @endif
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="{{ $companyInfo->facebook }}" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="{{ $companyInfo->linkedin }}" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>-->
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between lmcpadding">

        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}"
                class="logo d-flex align-items-center @if($companyInfo->tagline) border-end @endif">
                <!-- <img src="{{ $companyInfo->logo_src ? $companyInfo->logo_src : asset('images/front/ERA-Logo.png') }}" alt="{{ $companyInfo->logo_alt }}"> -->
                <img src="{{ asset('images/front/ERA-Logo.png') }}" alt="{{ $companyInfo->logo_alt }}">
            </a>
            @if($companyInfo->tagline)<sub
                class="d-none d-md-inline text-era-preferred pb-2 ms-2">{{ $companyInfo->tagline }}</sub>@endif
        </div>


        @include('web.front.partials.menu')
    </div>
</header><!-- End Header -->