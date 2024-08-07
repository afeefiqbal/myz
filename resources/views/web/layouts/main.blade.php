<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MYZ">
    <meta name="keywords" content="MYZ">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="author" content="MYZ">
    {{-- <link rel="icon" href="assets/images/favicon/3.png" type="image/x-icon"> --}}
    <title>The best electronic shop near you</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <!-- bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/bootstrap.css')}}">

    <!-- wow css -->
    <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}" />

    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/font-awesome.css')}}">

    <!-- feather icon css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/feather-icon.css')}}">

    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/slick/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/slick/slick-theme.css')}}">

    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bulk-style.css')}}">
    {{-- <link rel="stylesheet" href="https://themes.pixelstrap.com/fastkart/assets/css/bulk-style.css">
    <link rel="stylesheet" href="https://themes.pixelstrap.com/fastkart/assets/css/vendors/animate.css"> --}}

    <!-- Template css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/app.css')}}">
    <style>
        .goog-te-banner-frame.skiptranslate { display: none !important; }
        .goog-logo-link { display: none !important; }
        .goog-te-gadget { color: transparent !important; }
        body { top: 0px !important; }
    </style>
    <link id="color-link" rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,ar', // Add more languages here
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: true
            }, 'google_translate_element');
        }
    </script>
{{-- <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> --}}
</head>
<script type="text/javascript">
            var base_url = "{{ url('/') }}";
        var fc_path = "{{ asset('/') }}";
        var token = "{{ csrf_token() }}";
</script>


<body class="bg-effect">

    <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!-- Loader End -->

@include('web.layouts.header')
    @yield('content')
    <!-- mobile fix menu end -->
    @include('web.layouts.footer')