<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Home - ERA-InfoTech Ltd">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:site_name" content="ERA-InfoTech Ltd">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:label1" content="Est. reading time">
    <meta name="twitter:data1" content="5 minutes">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicon/cropped-fav-270x270.jpg') }}">
    @show
    <title>ERA-InfoTech Limited - @yield('title')</title>
    @section('css')
    <link rel="canonical" href="{{ route('home') }}">
    <link rel="icon" href="{{ asset('images/favicon/cropped-fav-32x32.jpg') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('images/favicon/cropped-fav-192x192.jpg') }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/cropped-fav-180x180.jpg') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Barlow:300,300i,400,400i,600,600i,700,700i|Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--<link rel="shortcut icon" href="{{ asset('images/admin/favicon.svg') }}" type="image/x-icon">--}}
    @show
    <!--sectego ssl image -->
    <script type="text/javascript">
    //<![CDATA[ 
    var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" :
        "http://www.trustlogo.com/");
    document.write(unescape("%3Cscript src='" + tlJsHost +
        "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
    //]]>
    </script>
</head>

<body>
    @yield('content')
    <div class="contact-bg-with-btn">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <p style="padding-top:10px; font-weight: 600;">We're Here <span style="color:#f67624">to Help</span>
                    </p>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('contact-new') }}" style="color: #FFFFFF; padding-top:10px;"><i
                                class="bi bi-envelope" style="font-size:14px;"></i>
                            &nbsp; Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('web.front.partials.footer')
    @section('js')
    <script src="{{ asset('js/app.js') }}" defer></script>
    @show
</body>

</html>