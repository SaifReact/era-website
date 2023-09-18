<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="footer-wrapper">
                <div class="footer-info">
                    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                        <!-- <img src="{{ $companyInfo->logo_src ? $companyInfo->logo_src : asset('images/front/ERA-Logo.png') }}"
                                alt="{{ $companyInfo->logo_alt }}"> -->
                        <img src="{{ asset('images/front/ERA-Logo.png') }}" alt="{{ $companyInfo->logo_alt }}">

                    </a>
                    @if($location)
                    <div class="footer-info-item">
                        <i class="bi bi-geo-alt"> </i>
                        <div>
                            <p style="font-size:14px;"> {{ $location->address }} </p>
                        </div>
                    </div>
                    @endif
                    @if($contact)
                    <div class="footer-info-item">
                        <i class="bi bi-telephone"></i>
                        <div>
                            @if($companyInfo->phone)<p>{{ $companyInfo->phone }}</p>@endif
                            <p style="font-size:14px;">{{ $contact->contact_no }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="footer-info-item">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <p style="font-size:14px;">{{ $companyInfo->email }}></p>
                        </div>
                    </div>
                    <div class="footer-info-item">
                        <i class="bi bi-stopwatch"></i>
                        <div>
                            <p style="font-size:14px;">{{ $companyInfo->open_days }}<br>{{ $companyInfo->duration }}</p>
                        </div>   
                    </div>
                </div>
                <div class="footer-links-container">
                    {!! $footerMenuItems !!}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="copyright">
                    <div class="social-links">
                        <a href="{{ $companyInfo->facebook }}" class="facebook"><i class="bi bi-facebook"></i></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ $companyInfo->linkedin }}" class="linkedin"><i
                                class="bi bi-linkedin bx bxl-linkedin"></i></a>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="credits">
                    &copy; Copyright <strong><span>{{ $companyInfo->website_name }}</span></strong>. All Rights
                    Reserved
                </div>
            </div>

        </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>