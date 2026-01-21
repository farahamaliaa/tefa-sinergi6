<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinergi6</title>

    <link rel="stylesheet" href="{{ asset('landing_assets/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_assets/css/responsive.css') }}">
    <link rel="shortcut icon" href="{{ asset('landing_assets/images/logo/smkn-6-jember.png') }}" type="image/x-icon">
    @yield('style')
</head>

<body>

    <div class="page_wrapper">

        <div id="preloader">
            <div class="circle-border">
                <div class="circle-core"></div>
            </div>
        </div>

        <div class="top_home_wraper white_option">

            <div class="container">
                <div class="anim_line dark_bg">
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('landing_assets/images/anim_line.png') }}" alt="anim_line"></span>
                </div>
            </div>

            @include('layouts.landing.header')

            {{-- @include('layouts.landing.banner') --}}
        </div>

        @yield('content')

        @include('layouts.landing.footer-landing')

        <div class="modal fade youtube-video" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <button id="close-video" type="button" class="button btn btn-default text-right" data-dismiss="modal">
                        <i class="icofont-close-line-circled"></i>
                    </button>
                    <div class="modal-body">
                        <div id="video-container" class="video-container">
                            <iframe id="youtubevideo" width="640" height="360" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('landing_assets/js/jquery.js') }}"></script>
    <script src="{{ asset('landing_assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing_assets/js/aos.js') }}"></script>
    <script src="{{ asset('landing_assets/js/main.js') }}"></script>
    @yield('script')

</body>

</html>
