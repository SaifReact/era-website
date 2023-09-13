<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3 col-md-12 footer-info">
                    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                        <!-- <img src="{{ $companyInfo->logo_src ? $companyInfo->logo_src : asset('images/front/ERA-Logo.png') }}"
                            alt="{{ $companyInfo->logo_alt }}"> -->
                        <img src="{{ asset('images/front/ERA-Logo.png') }}" alt="{{ $companyInfo->logo_alt }}">

                    </a>
                    @if($location)
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-lg-2"><i class="bi bi-geo-alt"> </i></div>
                        <div class="col-lg-10">
                            <p style="font-size:14px;"> {{ $location->address }} </p>
                        </div>
                    </div>
                    @endif
                    @if($contact)
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-lg-2"><i class="bi bi-telephone"></i></div>
                        <div class="col-lg-10">
                            @if($companyInfo->phone)<p>{{ $companyInfo->phone }}</p>@endif
                            <p style="font-size:14px;">{{ $contact->contact_no }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-lg-2"><i class="bi bi-envelope"></i></div>
                        <div class="col-lg-10">
                            <p style="font-size:14px;">{{ $companyInfo->email }}></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><i class="bi bi-stopwatch"></i></div>
                        <div class="col-lg-10">
                            <p style="font-size:14px;">{{ $companyInfo->open_days }}<br>{{ $companyInfo->duration }}</p>
                        </div>
                    </div>


                </div>

                {!! $footerMenuItems !!}

                <!-- <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Contact Us</h4>
                    <p>
                        @if($location)<a href="{{ $location->map_location }}"
                            target="_blank">{{ $location->address }}</a>
                        <br><br>@endif
                        @if($contact)<strong>Phone:</strong> <a
                            href="tel:{{ $contact->contact_no }}">{{ $contact->contact_no }}</a><br>@endif
                        <strong>Email:</strong> <a
                            href="mailto:{{ $companyInfo->email }}">{{ $companyInfo->email }}</a><br>
                    </p>

                </div> -->

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
                    &copy; Copyright <strong><span>{{ $companyInfo->website_name }}</span></strong>. All Rights Reserved
                </div>
            </div>

            <!-- <div class="credits"> -->


            <!-- <script language="JavaScript" type="text/javascript">
            TrustLogo("https://erainfotechbd.com/laracms/public/positivessl_trust_seal_sm_124x32.png", "CL1",
                "none");
            </script><a
                href="javascript:if(window.open('https://secure.trust-provider.com/ttb_searcher/trustlogo?v_querytype=W&amp;v_shortname=CL1&amp;v_search=https://www.erainfotechbd.com/&amp;x=6&amp;y=5','tl_wnd_credentials'+(new Date()).getTime(),'toolbar=0,scrollbars=1,location=1,status=1,menubar=1,resizable=1,width=374,height=660,left=60,top=120')){};tLlB(tLTB);"
                onmouseover="tLeB(event,'https://secure.trust-provider.com/ttb_searcher/trustlogo?v_querytype=C&amp;v_shortname=CL1&amp;v_search=https://www.erainfotechbd.com/&amp;x=6&amp;y=5','tl_popupCL1')"
                onmousemove="tLXB(event)" onmouseout="tLTC('tl_popupCL1')" ondragstart="return false;"><img
                    src="https://erainfotechbd.com/laracms/public/positivessl_trust_seal_sm_124x32.png" border="0"
                    onmousedown="return tLKB(event,'https://secure.trust-provider.com/ttb_searcher/trustlogo?v_querytype=W&amp;v_shortname=CL1&amp;v_search=https://www.erainfotechbd.com/&amp;x=6&amp;y=5');"
                    oncontextmenu="return tLLB(event);"></a>
            <div id="tl_popupCL1" name="tl_popupCL1"
                style="position:absolute;z-index:0;visibility: hidden;background-color: transparent;overflow:hidden;"
                onmouseover="tLoB('tl_popupCL1')" onmousemove="tLpC('tl_popupCL1')" onmouseout="tLpB('tl_popupCL1')">
                &nbsp;</div>
            <a href="https://www.instantssl.com/" id="comodoTL">Essential SSL</a> -->

            <!--Designed & Developed by <a href="https://www.gws-techsolution.com" target="_blank">GWS-Tech Solution</a>-->


        </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>